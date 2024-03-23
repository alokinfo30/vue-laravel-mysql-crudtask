mix.js('resources/js/app.js', 'public/js')    
//    .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
     module: {
       rules: [
         // ... other rules
         {
           test: /\.vue$/,
           loader: 'vue-loader',
           options: {
             loaders: {
               // ... other loaders
               js: 'babel-loader',
             },
           },
         },
       ],
     },
     plugins: [
       // ... other plugins
       new VueLoaderPlugin(), // Add VueLoaderPlugin for Vue.js
     ],
   });
