# Recruitment Timeline Tracker API

A RESTful API designed for tracking the candidate interview process built with **Laravel 12**.  
This application manages the lifecycle of a candidate's journey **(Timeline, Steps, and Status History)** using a professional **Repository–Service** architecture and **Unit Tests** using **PhpUnit**.

---

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Running the Application](#-running-the-application)
- [API Documentation](#-api-documentation)

---

## ✨ Features

- **Timeline Creation:**  
  Creation of a **Candidate** record and the linked **Timeline** record.

- **Step Creation:**  
  Creation of a new **Step** and its initial **Status** record.
  **Enforcement of the core business rule:** 
    A Step Category can only be used once per Timeline (handled by a custom validation rule).

- **Status Tracking:**  
  Creation of a new **Status** record for an existing **Step**.

- **Efficient Data Retrieval:**  
  Fetches the entire **Timeline**, including all **Steps**, and uses an optimized 
  **SQL technique** to retrieve only the single current status for each step.

---

## 🛠 Requirements

- **PHP >= 8.2**
- **Composer**
- **MySQL**

---

## 🚀 Installation

### 1. Clone the repository

```bash
 git clone <your-repo-url>
```

### 2. Install Dependencies

```bash
 composer install
```

### 3. Environment Setup

```bash
 cp .env.example .env
```

Update `.env`:

- **Set your database credentials:**

```ini
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
# CRUCIAL: Set session driver and cache store to file to prevent database errors on startup
SESSION_DRIVER=file
CACHE_STORE=file
```

### 4. Generate Application Key

```bash
 php artisan key:generate
```

### 5. Run Migrations and Seeders

```bash
 php artisan migrate:fresh --seed
```
This will create the necessary database tables and generate three Recruiters.
```ini
1. id->1, name->Recruiter A
2. id->2, name->Recruiter B
3. id->3, name->Recruiter C
```
You can find a database model diagram in the **database/diagram/** directory.

---

## 🏃 Running the Application

Start local development server:

```bash
 php artisan serve
```

Your API will be available at:

```bash
 http://localhost:8000/api
```

---

## 📖 API Documentation

* A full **OpenAPI (Swagger)** specification is available in the `http://localhost:8000/swagger/documentation#/` route.
* A postman collection is available in the **postman/** directory.

### Key Endpoints

| Method | Endpoint            | Description                                                         | Params                                                                             |
|--------|---------------------|---------------------------------------------------------------------|------------------------------------------------------------------------------------|
| POST   | /api/timelines      | Create new Candidate and new Timeline.                              | recruiter_id, candidate_name, candidate_surname                                    |
| POST   | /api/steps          | Create new Step and initial Status.                                 | recruiter_id, candidate_id, timeline_id,<br/> step_category_id, status_category_id |
| POST   | /api/statuses       | Update Step Status (Create new Status record).                      | recruiter_id, candidate_id, timeline_id,<br/> step_id, status_category_id          |
| GET    | /api/timelines/{id} | Fetch complete timeline with only the current status for each step. |                                                                                    |
---







---
