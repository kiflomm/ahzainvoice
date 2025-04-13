// CORS Fix for asset loading
document.addEventListener('DOMContentLoaded', function() {
  // Fix for preloaded assets
  const links = document.querySelectorAll('link[rel="preload"]');
  links.forEach(link => {
    if (!link.hasAttribute('as')) {
      const href = link.getAttribute('href');
      if (href.endsWith('.css')) {
        link.setAttribute('as', 'style');
      } else if (href.endsWith('.js')) {
        link.setAttribute('as', 'script');
      } else if (href.match(/\.(woff2?|ttf|eot)$/)) {
        link.setAttribute('as', 'font');
      } else if (href.match(/\.(png|jpg|jpeg|gif|svg)$/)) {
        link.setAttribute('as', 'image');
      }
    }
  });
}); 