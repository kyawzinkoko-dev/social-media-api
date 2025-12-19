# Social Media Backend API


## Tech Stack

- PHP 8.1+
- Laravel 12.x
- MySQL 8.0+
- JWT Authentication (tymon/jwt-auth)

## Installation


### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd social-media-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update the `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=social_media
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Generate JWT secret**
   ```bash
   php artisan jwt:secret
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```


## API Document

Base URL: `http://localhost:8000/api`

### Authentication

#### 1. Register
Create a new user account.

**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
    "name": "Kyaw Zin ",
    "email": "kyaw@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "user": {
        "id": 1,
        "name": "Kyaw Zin ",
        "email": "kyaw@example.com"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email format, unique
- `password`: required, min 8 characters, must match confirmation

---

#### 2. Login
Authenticate an existing user.

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
    "email": "kyaw@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "user": {
        "id": 1,
        "name": "Kyaw Zin ",
        "email": "kyaw@example.com"
    }
}
```

**Error Response (401):**
```json
{
    "error": "Invalid credentials"
}
```

---

#### 3. Logout
Invalidate the current authentication token.

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "message": "Successfully logged out"
}
```

---

### User Profile

#### Get Profile
Retrieve the authenticated user's profile information.

**Endpoint:** `GET /api/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "id": 1,
    "name": "Kyaw Zin ",
    "email": "kyaw@example.com",
    "created_at": "2025-12-19",
    "post_count": 5,
    "reaction_count": 12,
    "comment_count": 8
}
```

---

### Posts

#### 1. Create Post
Create a new post.

**Endpoint:** `POST /api/posts`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
title: "My First Post"
content: "This is the content of my post"
image: [file] (optional)
```

**Response (201):**
```json
{
    "id": 1,
    "user_id": 1,
    "title": "My First Post",
    "content": "This is the content of my post",
    "image": "posts/abc123.jpg",
    "created_at": "2025-12-18",
    "updated_at": "2025-12-18"
}
```

---

#### 2. Edit Post
Update an existing post (only by owner).

**Endpoint:** `PUT /api/posts/{postId}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "title": "Updated Title",
    "content": "Updated content",
    "image": "new-image-url.jpg"
}
```

**Response (200):**
```json
{
    "id": 1,
    "user_id": 1,
    "title": "Updated Title",
    "content": "Updated content",
    "image": "new-image-url.jpg",
    "created_at": "2025-12-18",
    "updated_at": "2025-12-18"
}
```

**Error Response (403):**
```json
{
    "error": "You are not authorized to edit this post"
}
```

---

#### 3. My Posts
Get all posts created by the authenticated user.

**Endpoint:** `GET /api/my-posts`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 15)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "title": "My Post",
            "content": "Post content",
            "image": "posts/image.jpg",
            "created_at": "2025-12-18",
            "updated_at": "2025-12-18"
        }
    ],
    "current_page": 1,
    "last_page": 2,
    "per_page": 15,
    "total": 20
}
```

---

### Newsfeed

#### 1. Get All Posts
Retrieve all posts with author info, reaction count, and comment count.

**Endpoint:** `GET /api/posts`

**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 15)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Sample Post",
            "content": "This is a sample post content",
            "image": "posts/image.jpg",
            "created_at": "2025-12-18",
            "author": {
                "id": 1,
                "name": "Kyaw Zin "
            },
            "reaction_count": 5,
            "comment_count": 3
        }
    ],
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 67
}
```

---

#### 2. Comment on Post
Add a comment to a post.

**Endpoint:** `POST /api/posts/{postId}/comments`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "content": "This is a great post!"
}
```

**Response (201):**
```json
{
    "id": 1,
    "post_id": 1,
    "user_id": 1,
    "content": "This is a great post!",
    "created_at": "2025-12-18",
    "updated_at": "2025-12-18"
}
```

**Error Response (404):**
```json
{
    "error": "Post not found"
}
```

---

#### 3. Reaction (Like/Unlike)
Toggle a reaction on a post.

**Endpoint:** `POST /api/posts/{postId}/reaction`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "type": "like"
}
```
**Avaliable type ** 
    like,love,haha,wow,sad,angry

**Response (200):**
```json
{
    "status": "added",
    "reaction_count": 6
}
```

**Response when removed (200):**
```json
{
    "status": "removed",
    "reaction_count": 5
}
```

**Error Response (404):**
```json
{
    "error": "Post not found"
}
```

---




