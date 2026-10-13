import {
    loadStripe,
    type PaymentIntentResult,
    type SetupIntentResult,
    type Stripe,
    type StripeElements,
} from '@stripe/stripe-js';

type DonationConfirmation = (
    stripe: Stripe,
    elements: StripeElements,
    returnUrl: string,
) => Promise<PaymentIntentResult | SetupIntentResult>;

interface DonationPaymentForm extends HTMLElement {
    donationConfirmation?: DonationConfirmation;
}

const stripePromises = new Map<string, ReturnType<typeof loadStripe>>();
const initializedForms = new WeakSet<HTMLElement>();

function getStripe(publishableKey: string): Promise<Stripe | null> {
    let stripePromise = stripePromises.get(publishableKey);

    if (!stripePromise) {
        stripePromise = loadStripe(publishableKey);
        stripePromises.set(publishableKey, stripePromise);
    }

    return stripePromise;
}

function showError(form: HTMLElement, message: string): void {
    const errorElement = form.querySelector<HTMLElement>('[data-donation-error]');

    if (errorElement) {
        errorElement.textContent = message;
        errorElement.hidden = false;
    }
}

function clearError(form: HTMLElement): void {
    const errorElement = form.querySelector<HTMLElement>('[data-donation-error]');

    if (errorElement) {
        errorElement.textContent = '';
        errorElement.hidden = true;
    }
}

function setProcessing(form: HTMLElement, processing: boolean): void {
    const button = form.querySelector<HTMLButtonElement>('[data-donation-submit]');
    const submitLabel = form.querySelector<HTMLElement>('[data-submit-label]');
    const processingLabel = form.querySelector<HTMLElement>('[data-processing-label]');

    if (!button) {
        return;
    }

    form.dataset.processing = String(processing);
    button.disabled = processing || form.dataset.ready !== 'true';
    button.setAttribute('aria-busy', String(processing));

    if (submitLabel) {
        submitLabel.hidden = processing;
    }

    if (processingLabel) {
        processingLabel.hidden = !processing;
    }
}

function getErrorMessage(error: unknown): string {
    if (typeof error === 'object' && error !== null && 'message' in error && typeof error.message === 'string') {
        return error.message;
    }

    return 'The payment could not be completed. Please try again.';
}

async function initializePaymentForm(element: HTMLElement): Promise<void> {
    if (initializedForms.has(element)) {
        return;
    }

    initializedForms.add(element);

    const form = element as DonationPaymentForm;
    const publishableKey = form.dataset.stripeKey;
    const clientSecret = form.dataset.clientSecret;
    const returnUrl = form.dataset.returnUrl;
    const paymentElementContainer = form.querySelector<HTMLElement>('[data-payment-element]');
    const submitButton = form.querySelector<HTMLButtonElement>('[data-donation-submit]');

    if (
        !publishableKey
        || !clientSecret
        || !returnUrl
        || !paymentElementContainer
        || !submitButton
        || !form.donationConfirmation
    ) {
        showError(form, 'The payment form could not be initialized. Please reload the page.');
        setProcessing(form, false);

        return;
    }

    setProcessing(form, false);

    try {
        const stripe = await getStripe(publishableKey);

        if (!stripe) {
            throw new Error('Stripe could not be loaded. Please reload the page and try again.');
        }

        const elements = stripe.elements({ clientSecret });
        const paymentElement = elements.create('payment');
        paymentElement.mount(paymentElementContainer);
        form.dataset.ready = 'true';
        setProcessing(form, false);

        submitButton.addEventListener('click', async () => {
            if (form.dataset.processing === 'true' || !form.donationConfirmation) {
                return;
            }

            setProcessing(form, true);
            clearError(form);

            try {
                const result = await form.donationConfirmation(stripe, elements, returnUrl);

                if ('error' in result && result.error) {
                    showError(form, result.error.message ?? 'The payment could not be completed. Please try again.');
                    setProcessing(form, false);
                }
            } catch (error: unknown) {
                showError(form, getErrorMessage(error));
                setProcessing(form, false);
            }
        });
    } catch (error: unknown) {
        showError(form, getErrorMessage(error));
        setProcessing(form, false);
    }
}

export function initializeDonationPayments(): void {
    document.querySelectorAll<HTMLElement>('[data-donation-payment]').forEach((form) => {
        void initializePaymentForm(form);
    });
}

export function resetDonationPaymentForms(): void {
    document.querySelectorAll<HTMLElement>('[data-donation-payment]').forEach((form) => {
        setProcessing(form, false);
    });
}
