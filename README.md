# BLOOCODE Backend Technical Assessment

This repository contains the Backend Developer Technical Assessment, covering:
1. **RESTful API for Podcast Platform (Sanctum & Swagger)**
2. **Deliver clean architecture, modular code, and scalable structure**
3. **Include:**
- Pagination, sorting, and filtering for list endpoints.
- Relationships between Podcasts, Episodes, and Categories.
- API resource responses, form request validations, and proper error handling.
- Eloquent relationships and model factories.
4. **Provide complete and interactive API documentation using Swagger or Postman.**
5. **Dockerized for local setup and deployment simulation.**

---

## **🚀 Project Setup & Installation**
## Clone the Repository
- git clone git@github.com:davidigbo/podcast-api.git
- cd podcast-api

## Install Dependencies
Ensure you have Composer installed, then run:
- composer install

## Configure the Environment
- Copy the .env.example file and update your database credentials.
- cp .env.example .env

## Generate the application key:
- php artisan key:generate

## Set Up the Database
- Run the migrations to create the necessary tables:
  - php artisan migrate --seed


## Run the Application
- Start the Laravel development server:
 - php artisan serve

 ## Now, visit:
- 📌 http://127.0.0.1:8001 to access the application.

## 🛠️ Task: Podcast Platform API

- RESTful API for Podcast Platform (Sanctum & Swagger)
- Deliver clean architecture, modular code, and scalable structure**
 -- Include:
   - Pagination, sorting, and filtering for list endpoints.
   - Relationships between Podcasts, Episodes, and Categories.
   - API resource responses, form request validations, and proper error handling.
   - Eloquent relationships and model factories.
- Provide complete and interactive API documentation using Swagger or Postman.
- Dockerized for local setup and deployment simulation.

## 📖 API Documentation (Swagger)
Swagger documentation is available at:
- 📌 http://127.0.0.1:8001/api/documentation

- To regenerate Swagger docs:
    - php artisan l5-swagger:generate

## 👥 Authors <a name="authors"></a>

👤 **David Igbo**

- GitHub: [@davidigbo](https://github.com/davidigbo)
- Twitter: [@davidigbo1](https://twitter.com/davidigbo1)
- LinkedIn: [davidigbo/](https://www.linkedin.com/in/davidigbo/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## 🙏 Acknowledgments <a name="acknowledgements"></a>

> I will like to thank BLOOCODE for this opportunity giving to me to work on this project.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## License

## Test API endpoint using Postman:

## 1. Testing the **User API Endpoint**

### Step 1: Authenticate the User (Get Token)

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/auth/register` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
  "name": "John Peter",
 "email": "test@laravel.com",
  "password": "12345678",
  "password_confirmation": "2345678"
}
```
> On a successful register, the API will return this:

```json
{
    "message": "User registered successfully",
    "user": {
        "name": "John Peter",
        "email": "test@laravel.com",
        "updated_at": "2025-04-24T15:24:25.000000Z",
        "created_at": "2025-04-24T15:24:25.000000Z",
        "id": 12
    }
}
```

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/auth/login` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
  "email": "user@example.com",
  "password": "12345678"
}
```

```json
{
    "message": "Login successful",
    "access_token": "1|MtbOB*************************************",
    "token_type": "Bearer",
    "user": {
        "id": 12,
        "name": "John Peter",
        "email": "test@laravel.com",
        "email_verified_at": null,
        "updated_at": "2025-04-24T15:24:25.000000Z",
        "created_at": "2025-04-24T15:24:25.000000Z",
    }
}
```

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/auth/logout` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
  - "email": "user@example.com",
  - "password": "12345678"

```json
{
    "message": "Logged out successfully"
}
```

### Step 2: The signed user can create a Product 

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/v1/categories` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
    "name": "Book",
    "slug": "Book"
}
```

> On a successful create a category, the API will return this:

```json
 {
    "message": "Category created successfully",
    "category": {
        "name": "Tech",
        "slug": "tech",
        "updated_at": "2025-04-24T15:24:25.000000Z",
        "created_at": "2025-04-24T15:24:25.000000Z",
        "id": 2
    }
}
```

 **Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/categories` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
```

>  This will return list of all API endpoints:

```json
{
    "categories": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Book",
                "slug": "book",
                "created_at": "2025-04-22T15:19:44.000000Z",
                "updated_at": "2025-04-22T15:19:44.000000Z"
            },
            {
                "id": 2,
                "name": "Tech",
                "slug": "tech",
                "created_at": "2025-04-22T15:24:25.000000Z",
                "updated_at": "2025-04-22T15:24:25.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8001/api/v1/categories?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8001/api/v1/categories?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8001/api/v1/categories?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8001/api/v1/categories",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

**Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/categories/2` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
    "name": "Tech",
    "slug": "tech",
}     
```

> This will return API endpoints with a particular id:

```json
{
    "id": 2,
     "name": "Tech",
     "slug": "tech",
    "created_at": "2025-04-22T15:24:25.000000Z",
    "updated_at": "2025-04-22T15:24:25.000000Z"
}
```

**Method**: `PUT`
- **URL**: `http://127.0.0.1:8001/api/v1/categories/2` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
    "name": "Tech",
    "slug": "tech",
}
```

> This will return updated API endpoints with a particular id:

```json
{
    "id": 2,
     "name": "MEDICAL",
     "slug": "medical",
    "created_at": "2025-04-22T15:24:25.000000Z",
    "updated_at": "2025-04-22T15:24:25.000000Z"
}
```

**Method**: `DELETE`
- **URL**: `http://127.0.0.1:8001/api/v1/categories/2` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
    "id": 2,
     "name": "Tech",
     "slug": "tech",
    "created_at": "2025-04-22T15:24:25.000000Z",
    "updated_at": "2025-04-22T15:24:25.000000Z"
}
```

> This will delete API endpoints with a particular id and return this:

```json
{
    "message": "Category deleted successfully"
}
```
## Podcasts API endpoints
- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/v1/podcasts` 
  > Use form-data on postman
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
        "title": "Tech",
        "description": "Tech is a lucrative career path",
        "category_id": "4",
        "author": "Helen",
        "is_featured": true,
        "image": "lara.png",
}        
```

> On a successful create a podcast, the API will return this:

```json
  {
    "message": "Podcast created successfully",
    "podcast": {
        "title": "Tech",
        "description": "Tech is a lucrative career path",
        "category_id": 4,
        "author": "Helen",
        "is_featured": 1,
        "image": "images/9bFThVo8kkdh3cLXUayR6CJnVLOjDFY7pzsZKAF0.jpg",
        "updated_at": "2025-04-24T08:53:45.000000Z",
        "created_at": "2025-04-24T08:53:45.000000Z",
        "id": 1
    }
}
```

 **Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/podcasts` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
```

>  This will return list of all API endpoints:

```json
{
    "podcasts": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "category_id": 4,
                "title": "Tech",
                "description": "Tech is a lucrative career path",
                "image": "images/9bFThVo8kkdh3cLXUayR6CJnVLOjDFY7pzsZKAF0.jpg",
                "is_featured": false,
                "author": "Helen",
                "created_at": "2025-04-23T08:50:56.000000Z",
                "updated_at": "2025-04-23T08:50:56.000000Z"
            },
            {
                "id": 2,
                "category_id": 4,
                "title": "Tech",
                "description": "Tech is a lucrative career path",
                "image": "images/ApBfiYO0Dgm2l9csIjku8ESwKv3hO2yIr5AwGgbN.jpg",
                "is_featured": true,
                "author": "Helen",
                "created_at": "2025-04-23T08:53:20.000000Z",
                "updated_at": "2025-04-23T08:53:20.000000Z"
            },
            {
                "id": 3,
                "category_id": 4,
                "title": "Tech",
                "description": "Tech is a lucrative career path",
                "image": "images/2SvfrEVgzU3Zj1d36hqCJ4BgL6RoU4mNh7LyWcF6.jpg",
                "is_featured": false,
                "author": "Helen",
                "created_at": "2025-04-23T08:53:29.000000Z",
                "updated_at": "2025-04-23T08:53:29.000000Z"
            },
            {
                "id": 4,
                "category_id": 4,
                "title": "Tech",
                "description": "Tech is a lucrative career path",
                "image": "images/FNzuFcqhqo5EMOlCQj7QHWIoP3cF3vQP9yAk17rR.jpg",
                "is_featured": true,
                "author": "Helen",
                "created_at": "2025-04-23T08:53:45.000000Z",
                "updated_at": "2025-04-23T08:53:45.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8001/api/v1/podcasts?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8001/api/v1/podcasts?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8001/api/v1/podcasts?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8001/api/v1/podcasts",
        "per_page": 10,
        "prev_page_url": null,
        "to": 4,
        "total": 4
    }
}
```

**Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/podcasts/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json   
```

> This will return API endpoints with a particular id:

```json
  {
    "message": "Podcast created successfully",
    "podcast": {
        "title": "Tech",
        "description": "Tech is a lucrative career path",
        "category_id": 4,
        "author": "Helen",
        "is_featured": true,
        "image": "images/9bFThVo8kkdh3cLXUayR6CJnVLOjDFY7pzsZKAF0.jpg",
        "updated_at": "2025-04-24T08:53:45.000000Z",
        "created_at": "2025-04-24T08:53:45.000000Z",
        "id": 1
    }
}
```

**Method**: `PUT`
- **URL**: `http://127.0.0.1:8001/api/v1/podcasts/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
        "title": "Medical",
        "description": "Medical is good",
        "category_id": "4",
        "author": "Helen",
        "is_featured": 0,
        "image": "lara.png",
}  
```

> This will return updated API endpoints with a particular id:

```json
  {
    "message": "Podcast updated successfully",
    "podcast": {
        "title": "Medical",
        "description": "Medical is good",
        "category_id": 4,
        "author": "Helen",
        "is_featured": false,
        "image": "images/9bFThVo8kkdh3cLXUayR6CJnVLOjDFY7pzsZKAF0.jpg",
        "updated_at": "2025-04-24T08:53:45.000000Z",
        "created_at": "2025-04-24T08:53:45.000000Z",
        "id": 1
    }
}
```

**Method**: `DELETE`
- **URL**: `http://127.0.0.1:8001/api/v1/podcasts/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
        "title": "Tech",
        "description": "Tech is a lucrative career path",
        "category_id": "4",
        "author": "Helen",
        "is_featured": 0,
        "image": "lara.png",
}  
```

> This will delete API endpoints with a particular id and return this:

```json
{
    "message": "Podcast deleted successfully"
}
```

## Episodes API endpoints

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8001/api/v1/episodes` 
  > Use form-data on postman
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
        "podcast_id": "4",
        "title": "Tech",
        "audio_url": "file_example_MP3_700KB.mp3",
        "duration": "30",
        "release_date": "2024-10-20"
}        
```

> On a successful create a episode, the API will return this:

```json
  {
    "message": "Episode created successfully",
    "episode": {
        "podcast_id": "4",
        "title": "Tech",
        "audio_url": "audios/GsgaX5P6OGoCVTtoxqa3n2KF61Jw0HPiTA012PZi.mp3",
        "duration": "30",
        "release_date": "2024-10-20T00:00:00.000000Z",
        "updated_at": "2025-04-23T09:44:31.000000Z",
        "created_at": "2025-04-23T09:44:31.000000Z",
        "id": 2
    }
}
```

 **Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/episodes` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
```

>  This will return list of all API endpoints:

```json
{
    "episodes": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "podcast_id": 4,
                "title": "Tech",
                "audio_url": "audios/5Cy9ld9uuIepml4KY1q094J7amnAL661dkC1rY5X.mp3",
                "duration": "30",
                "release_date": "2024-10-20T00:00:00.000000Z",
                "created_at": "2025-04-23T09:43:06.000000Z",
                "updated_at": "2025-04-23T09:43:06.000000Z"
            },
            {
                "id": 2,
                "podcast_id": 4,
                "title": "Tech",
                "audio_url": "audios/GsgaX5P6OGoCVTtoxqa3n2KF61Jw0HPiTA012PZi.mp3",
                "duration": "30",
                "release_date": "2024-10-20T00:00:00.000000Z",
                "created_at": "2025-04-23T09:44:31.000000Z",
                "updated_at": "2025-04-23T09:44:31.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8001/api/v1/episodes?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8001/api/v1/episodes?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8001/api/v1/episodes?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8001/api/v1/episodes",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

**Method**: `GET`
- **URL**: `http://127.0.0.1:8001/api/v1/episodes/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json   
```

> This will return API endpoints with a particular id:

```json
  {
    {
                "id": 1,
                "podcast_id": 4,
                "title": "Tech",
                "audio_url": "audios/5Cy9ld9uuIepml4KY1q094J7amnAL661dkC1rY5X.mp3",
                "duration": "30",
                "release_date": "2024-10-20T00:00:00.000000Z",
                "created_at": "2025-04-23T09:43:06.000000Z",
                "updated_at": "2025-04-23T09:43:06.000000Z"
    }
}
```

**Method**: `PUT`
- **URL**: `http://127.0.0.1:8001/api/v1/episodes/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
                "podcast_id": 4,
                "title": "Medical",
                "audio_url": "file_example_MP3_700KB.mp3",
                "duration": "40",
                "release_date": "2024-10-20T00:00:00.000000Z",
}, 
```

> This will return updated API endpoints with a particular id:

```json
  {
    "message": "episodes updated successfully",
    {
                "id": 1,
                "podcast_id": 4,
                "title": "Medical",
                "audio_url": "audios/5Cy9ld9uuIepml4KY1q094J7amnAL661dkC1rY5X.mp3",
                "duration": "40",
                "release_date": "2024-10-20T00:00:00.000000Z",
                "created_at": "2025-04-23T09:43:06.000000Z",
                "updated_at": "2025-04-23T09:43:06.000000Z"
    }
}
```

**Method**: `DELETE`
- **URL**: `http://127.0.0.1:8001/api/v1/episodes/1` 
  
- **Body** (choose `x-www-form-urlencoded` in Postman):
```json
{
                "podcast_id": 4,
                "title": "Medical",
                "audio_url": "file_example_MP3_700KB.mp3",
                "duration": "40",
                "release_date": "2024-10-20T00:00:00.000000Z",
}
```

> This will delete API endpoints with a particular id and return this:

```json
{
    "message": "Episode deleted successfully"
}
```

