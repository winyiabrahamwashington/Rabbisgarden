require('dotenv').config();
const express = require('express');
const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);
const bodyParser = require('body-parser');
const helmet = require('helmet');
const cors = require('cors');
const mongoose = require('mongoose');

// Initialize Express app
const app = express();

// Middleware
app.use(helmet());
app.use(cors({
  origin: process.env.FRONTEND_URL || 'http://localhost:3000'
}));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Database connection
mongoose.connect(process.env.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(() => console.log('Connected to MongoDB'))
.catch(err => console.error('MongoDB connection error:', err));

// Donation model
const donationSchema = new mongoose.Schema({
  amount: { type: Number, required: true },
  currency: { type: String, default: 'usd' },
  donorName: { type: String, required: true },
  donorEmail: { type: String, required: true },
  paymentMethod: { type: String, required: true },
  transactionId: { type: String },
  status: { type: String, default: 'pending' },
  donationType: { type: String },
  message: { type: String },
  createdAt: { type: Date, default: Date.now }
});

const Donation = mongoose.model('Donation', donationSchema);

// Process Stripe payment
app.post('/process-payment', async (req, res) => {
  try {
    const { paymentMethodId, amount, donorName, donorEmail, donationType } = req.body;

    // Validate input
    if (!paymentMethodId || !amount || !donorName || !donorEmail) {
      return res.status(400).json({ error: 'Missing required fields' });
    }

    // Create payment intent
    const paymentIntent = await stripe.paymentIntents.create({
      amount,
      currency: 'usd',
      payment_method: paymentMethodId,
      confirmation_method: 'manual',
      confirm: true,
      receipt_email: donorEmail,
      metadata: {
        donor_name: donorName,
        donation_type: donationType || 'custom'
      }
    });

    // Create donation record
    const donation = new Donation({
      amount: amount / 100,
      donorName,
      donorEmail,
      paymentMethod: 'card',
      transactionId: paymentIntent.id,
      status: paymentIntent.status,
      donationType
    });

    await donation.save();

    // Handle 3D Secure if needed
    if (paymentIntent.status === 'requires_action') {
      return res.json({
        requiresAction: true,
        clientSecret: paymentIntent.client_secret
      });
    }

    if (paymentIntent.status === 'succeeded') {
      return res.json({
        success: true,
        paymentIntentId: paymentIntent.id
      });
    }

    throw new Error(`Unexpected payment status: ${paymentIntent.status}`);

  } catch (error) {
    console.error('Payment processing error:', error);
    res.status(500).json({ error: error.message });
  }
});

// Record PayPal donation
app.post('/record-paypal-donation', async (req, res) => {
  try {
    const { amount, transactionId, payerName, payerEmail, donationType } = req.body;

    const donation = new Donation({
      amount,
      donorName: payerName,
      donorEmail: payerEmail,
      paymentMethod: 'paypal',
      transactionId,
      status: 'completed',
      donationType
    });

    await donation.save();

    res.json({ success: true });

  } catch (error) {
    console.error('Error recording PayPal donation:', error);
    res.status(500).json({ error: error.message });
  }
});

// Stripe webhook handler
app.post('/stripe-webhook', bodyParser.raw({type: 'application/json'}), async (req, res) => {
  const sig = req.headers['stripe-signature'];
  let event;

  try {
    event = stripe.webhooks.constructEvent(
      req.body,
      sig,
      process.env.STRIPE_WEBHOOK_SECRET
    );
  } catch (err) {
    console.error('Webhook signature verification failed:', err);
    return res.status(400).send(`Webhook Error: ${err.message}`);
  }

  try {
    switch (event.type) {
      case 'payment_intent.succeeded':
        const paymentIntent = event.data.object;
        await Donation.findOneAndUpdate(
          { transactionId: paymentIntent.id },
          { status: 'completed' }
        );
        break;

      case 'payment_intent.payment_failed':
        const failedPayment = event.data.object;
        await Donation.findOneAndUpdate(
          { transactionId: failedPayment.id },
          { status: 'failed', error: failedPayment.last_payment_error?.message }
        );
        break;

      default:
        console.log(`Unhandled event type: ${event.type}`);
    }

    res.json({ received: true });
  } catch (error) {
    console.error('Error handling webhook:', error);
    res.status(500).json({ error: error.message });
  }
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});