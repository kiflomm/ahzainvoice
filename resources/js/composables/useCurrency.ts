/**
 * Utility for currency formatting
 */

/**
 * Format a value as currency
 * @param value The value to format (can be number or string with or without currency symbol)
 * @param currency The currency code (default: ETB)
 * @param locale The locale (default: en-US)
 * @returns Formatted currency string
 */
export const formatCurrency = (
  value: string | number,
  currency: string = 'ETB',
  locale: string = 'en-US'
): string => {
  // If value is a string, remove any existing currency symbols or non-numeric characters except decimal point
  const numericValue = typeof value === 'string' 
    ? parseFloat(value.replace(/[^\d.-]/g, ''))
    : value;
  
  return new Intl.NumberFormat(locale, {
    style: 'currency',
    currency: currency,
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(numericValue);
};

/**
 * Hook for using currency formatting in components
 */
export const useCurrency = () => {
  return {
    formatCurrency,
  };
};

export default useCurrency; 