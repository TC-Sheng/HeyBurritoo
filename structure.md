# HeyBurrito Project Structure Documentation

## Project Overview
HeyBurrito is an open-source Slack Bot project designed to replace HeyTaco functionality.

## Tech Stack
- PHP 8.1+
- Laravel Framework
- MySQL Database
- Slack API

## Directory Structure
```
HeyBurrito/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BurritoController.php    # Handles Slack events
│   │   │   ├── EventController.php      # Manages event storage
│   │   │   ├── UserController.php       # User management
│   │   │   └── MockSlackAPI.php         # Slack API simulation
│   │   ├── Middleware/
│   │   │   ├── SlackEvent.php           # Slack event validation
│   │   │   └── TokenAuth.php            # Token authentication
│   │   └── Requests/
│   │       └── EventPostRequest.php     # Event request validation
│   ├── Models/
│   │   ├── Event.php                    # Event model
│   │   ├── User.php                     # User model
│   │   └── Burrito.php                  # Burrito model
│   └── Slack/
│       └── SlackUserData.php            # Slack user data processing
├── config/
├── database/
│   └── migrations/                      # Database migration files
├── routes/
│   └── api.php                          # API route definitions
└── tests/                               # Test files
```

## API Specifications

### 1. Event API
```
POST /api/event
Purpose: Handle Slack events
Request Body:
{
    "token": "verification_token",
    "team_id": "team_id",
    "event": {
        "type": "app_mention",
        "user": "user_id",
        "text": "message_content",
        "channel": "channel_id"
    },
    "type": "event_callback"
}
Response:
- Success: 200 OK
- Failure: Appropriate error status code
```

### 2. User API
```
GET /api/user
Purpose: Get user list
Authentication: Required

POST /api/user
Purpose: Create new user
Authentication: Required
Request Body:
{
    "username": "username"
}

PATCH /api/user/{username}
Purpose: Update user information
Authentication: Required

DELETE /api/user/{userId}
Purpose: Delete user
Authentication: Required
```

### 3. Slack Mock API
```
GET /api/slack
Purpose: Test endpoint

GET /api/slack/event/{eventType}
Purpose: Simulate Slack events
Parameters:
- eventType: challenge/app_mention/message/slash_command

GET /api/slack/users.list
Purpose: Simulate Slack users list API
```

## Database Structure

### events table
- id: Primary key
- type: Event type
- user: User ID
- channel: Channel ID
- text: Message content
- created_at: Creation timestamp
- updated_at: Update timestamp

### users table
- id: Primary key
- user_id: Slack user ID
- name: Username
- created_at: Creation timestamp
- updated_at: Update timestamp

### burrito table
- id: Primary key
- burrito_giver: Giver ID
- burrito_receiver: Receiver ID
- message_sent_to_giver: Message sent to giver flag
- message_sent_to_receiver: Message sent to receiver flag
- created_at: Creation timestamp
- updated_at: Update timestamp

## Environment Requirements
- PHP 8.1+
- MySQL 5.7+
- Composer
- SSL Certificate (for Slack API)
- Slack App Configuration

## Configuration Instructions
1. Copy .env.example to .env
2. Configure database connection
3. Set Slack API credentials
4. Configure log level

## Deployment Instructions
1. Install dependencies: `composer install`
2. Generate key: `php artisan key:generate`
3. Run migrations: `php artisan migrate`
4. Start server: `php artisan serve`
5. Configure Slack App event subscriptions 