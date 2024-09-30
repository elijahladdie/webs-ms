# Website posts managment system

This is a webs-ms subscription platform where users can subscribe to multiple websites and receive email notifications whenever a new post is published. 
## Features
- Users can subscribe to websites.
- Websites can publish posts.
- Subscribers will receive an email with the post title and description when a new post is published.
- Emails are sent using a background job queue to avoid performance issues.
- The system ensures that duplicate emails are not sent for the same post to the same subscriber.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/elijahladdie/webs-ms.git
    cd webs-ms
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Create a `.env` file from `.env.example`:

    ```bash
    cp .env.example .env
    ```

4. Set your database credentials in the `.env` file:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

5. Run migrations to create the necessary database tables:

    ```bash
    php artisan migrate
    ```

6. Generate an application key:

    ```bash
    php artisan key:generate
    ```

## Usage

### 1. Generate Controllers and Routes
To generate the necessary controllers (`PostController`, `SubscriptionController`, `WebsiteController`) and automatically append the corresponding routes to the `api.php` file, run:

```bash
php artisan make:url-controllers
```

This command generates the following routes:
- `/api/posts`
- `/api/subscriptions`
- `/api/websites`

### 2. Send Post Emails
To send emails to subscribers about new posts, run:

```bash
php artisan send:post-emails
```

This command will:
- Check for new posts that haven’t been sent to subscribers yet.
- Send an email to each subscriber with the post details.
- Ensure that no duplicate emails are sent for the same post.

### 3. Run Queues for Background Jobs
The email sending is queued for better performance. To start processing the job queue, run:

```bash
php artisan queue:work
```

