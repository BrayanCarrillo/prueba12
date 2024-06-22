const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = function(app) {
  app.use(
    '/api',  // Ruta base que se va a redirigir
    createProxyMiddleware({
      target: 'https://prueba12-production.up.railway.app',  // URL del servidor backend
      changeOrigin: true,  // Habilita los cambios de origen
      secure: false,  // Deshabilita la verificación SSL
    })
  );
};
