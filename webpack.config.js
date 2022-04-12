const path = require('path');

module.exports = {
  entry: 'boostrap/app.js',
  output: {
    filename: 'app.js',
    path: path.resolve(__dirname, 'public/js'),
  },
};