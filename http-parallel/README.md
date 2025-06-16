## Exemple de requêtes paginées parallélisées avec Symfony HTTP Client et des Generators PHP

This project demonstrates how to make parallel HTTP requests to paginated resources using Symfony HTTP Client and PHP Generators.

### Project Structure

- `server.php`: A Symfony Framework server that provides:
  - A root endpoint (`/`) that returns JSON data with items, from/to parameters, and the current time

- `client.php`: A client that demonstrates:
  - Basic HTTP requests using Symfony HTTP Client
  - Parallel requests to paginated resources using PHP Generators

### How to Run

1. Start the server (choose one of the following options):

   a. Using PHP's built-in web server with Symfony's public/index.php:
   ```
   make run-server
   ```

   b. Using PHP's built-in web server with Symfony's public directory:
   ```
   make run-server-symfony
   ```

   c. Using FrankenPHP in Docker (worker mode) with Symfony's public/index.php:
   ```
   make run-server-frankenphp
   ```

2. In another terminal, run the client:
   ```
   make run-client
   ```

### How It Works

The client uses PHP Generators to create requests for each page of items. The Symfony HTTP Client handles these requests in parallel, and the responses are processed as they come in.

1. The client first makes a request to the first page to determine the total number of pages.
2. It then creates a Generator that yields HTTP requests for each page.
3. As the Generator is iterated over, the requests are sent in parallel.
4. The responses are processed as they are received, without waiting for all requests to complete.

This approach is more efficient than making sequential requests, especially for paginated resources with many pages.

### About FrankenPHP

FrankenPHP is a modern PHP app server built on top of Caddy server. It offers several advantages:

- **Worker Mode**: Keeps PHP workers alive between requests, improving performance by avoiding the overhead of starting a new PHP process for each request
- **HTTP/3 Support**: Uses the latest HTTP protocol for faster web communication
- **Automatic HTTPS**: Provides secure connections out of the box
- **PHP-FPM Compatibility**: Works with existing PHP-FPM configurations

When running the server with `make run-server-frankenphp`, Docker is used to run FrankenPHP in worker mode, which provides better performance than PHP's built-in web server.
