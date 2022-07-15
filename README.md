## Steps to Reproduce

1- Install Laravel.
2- `composer require laravel/jetstream`
3- `php artisan jetstream:install inertia --teams`
4- `php artisan jetstream:install inertia --ssr`
5- `npm install`
6- Create MySQL database (bug_report) and connect in .env
7- `php artisan migrate:fresh`
8- make Product model with migration (name & slug)
9- User hasMany products - Product belongsTo user.
10- Make a form and routes to submit a product at `resources/js/Pages/Welcome.vue` and redirect to ProductShow
11- `php artisan serve --host example.test --port 80`
12- `npm run dev`
13- Register - got to example.test - submit the form
You will encounter CORS errors.

```
Access to XMLHttpRequest at 'http://1.example.test/product-one' (redirected from 'http://example.test/products/create') from origin 'http://example.test' has been blocked by CORS policy: Response to preflight request doesn't pass access control check: No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

14- add '\*' to path and `'x-inertia'` to exposed headers at cors.php and submit the form again.

## Expected behavior

You should get redirected to the new route with the subdomain `{user_id}.example.test/{product_slug}`

## Current behavior

-   You get redirected to a wrong url `example.test/{product_slug}` and the subdomain gets completely ignored.
-   The page contains your product but on refresh it shows 404 and when you manually type the route url in the browser (for example: `1.example.test/product-one`) You find your route working with the correct product.

![Laravel-bug](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/upf75jcfjdjbfy4jg31m.gif)
