import {
	initializeDonationPayments,
	resetDonationPaymentForms,
} from './stripe-donation';

type FluxAppearance = 'system' | 'light' | 'dark';

interface FluxWindow extends Window {
	Flux?: {
		applyAppearance: (appearance: FluxAppearance) => void;
	};
}

function normalizePath(path: string): string {
	const normalizedPath = path.replace(/\/+$/, '');

	return normalizedPath || '/';
}

function getLightThemePaths(): string[] {
	const serializedPaths = document.documentElement.dataset.lightThemePaths;

	if (!serializedPaths) {
		return [];
	}

	try {
		const paths: unknown = JSON.parse(serializedPaths);

		return Array.isArray(paths)
			? paths.filter((path: unknown): path is string => typeof path === 'string').map(normalizePath)
			: [];
	} catch {
		return [];
	}
}

function syncTheme(): void {
	const currentPath = normalizePath(window.location.pathname);
	const lightThemePaths = getLightThemePaths();

	if (lightThemePaths.includes(currentPath)) {
		document.documentElement.classList.remove('dark');

		return;
	}

	const flux = (window as FluxWindow).Flux;
	const savedAppearance = window.localStorage.getItem('flux.appearance');
	const appearance: FluxAppearance = savedAppearance === 'light' || savedAppearance === 'dark'
		? savedAppearance
		: 'system';

	flux?.applyAppearance(appearance);
}

function initializeApplication(): void {
	syncTheme();
	initializeDonationPayments();
}

initializeApplication();

document.addEventListener('livewire:navigated', initializeApplication);
window.addEventListener('pageshow', resetDonationPaymentForms);
