#  Healthcare REST API (Laravel)

## Objective
Build a RESTful API to manage Patients and Appointments with proper validation, business rules.
API requests and responses are documented in this README and were tested using Postman.

---

## Tech Stack
- Tech Stack

PHP: 8.x
Laravel: 12.x
Database: MySQL
ORM: Eloquent
API Type: REST (JSON responses)
API Testing: Postman

### Project Details
Time Taken: 6–8 hours


##  Setup Instructions

### Clone Repository
```bash
git clone https://github.com/Ashutoshxo/healthcare-api.git
cd healthcare-api
composer install

Environment Setup 

cp .env.example .env
php artisan key:generate


Update Database Credentials (.env)

DB_DATABASE=healthcare
DB_USERNAME=root
DB_PASSWORD=root
that was mein but replace it your 

Run Migrations

php artisan migrate

and then start server 

php artisan serve
```

🗄 Database Schema

Patients Table (patients)
| Column     | Type      | Notes            |
| ---------- | --------- | ---------------- |
| id         | bigint    | Primary Key      |
| full_name  | string    | Required         |
| phone      | string    | Required, Unique |
| email      | string    | Required, Unique |
| dob        | date      | Nullable         |
| created_at | timestamp | Auto             |
| updated_at | timestamp | Auto             |


 Appointments Table (appointments)

| Column           | Type      | Notes                          |
| ---------------- | --------- | ------------------------------ |
| id               | bigint    | Primary Key                    |
| patient_id       | bigint    | Foreign Key → patients.id      |
| doctor_name      | string    | Required                       |
| appointment_date | date      | Required                       |
| appointment_time | time      | Required                       |
| status           | string    | booked / completed / cancelled |
| notes            | text      | Nullable                       |
| deleted_at       | timestamp | Soft delete                    |
| created_at       | timestamp | Auto                           |
| updated_at       | timestamp | Auto                           |

 Relationships
```bash 
Patient has many Appointments

Appointment belongs to Patient

Unique Constraint

(patient_id, appointment_date, appointment_time)

 API Endpoints
 Available Routes
POST    /api/patients
GET     /api/patients
GET     /api/patients/{id}

POST    /api/appointments
GET     /api/appointments
PATCH   /api/appointments/{id}/status
DELETE  /api/appointments/{id}

 Patients API
 Create Patient

POST /api/patients

{
  "full_name": "Riya Sharma",
  "phone": "9876543210",
  "email": "riya@gmail.com",
  "dob": "2001-02-12"
}
 List Patients (Search + Pagination)
GET /api/patients?search=9876&page=1
 Get Patient Details (Latest 5 Appointments)
GET /api/patients/{id}
 Appointments API Create Appointment

POST /api/appointments

{
  "patient_id": 1,
  "doctor_name": "Dr. Mehta",
  "appointment_date": "2025-12-20",
  "appointment_time": "10:30",
  "notes": "First consultation"
}

List Appointments (Filter + Pagination)
GET /api/appointments?status=booked&date=2025-12-20&page=1

 Update Appointment Status

PATCH /api/appointments/{id}/status

{
  "status": "completed"
}

🗑 Delete Appointment (Soft Delete)
DELETE /api/appointments/{id}

 Business Rules Implemented

Appointments cannot be created in the past

Duplicate appointment slot for the same patient is not allowed

Strong request validation using Form Request classes

Secure mass assignment handling

Soft deletes implemented for appointments

Proper HTTP Status Codes

201 Created

422 Validation Error

404 Resource Not Found

  API Testing

All endpoints tested using Postman

JSON request bodies used

Both success and validation failure cases verified

 Assumptions

Authentication is not required as it was not part of the assignment scope

Patient phone and email are unique identifiers

Appointment status is limited to: booked, completed, cancelled

One patient cannot book multiple appointments at the same date and time

Soft delete is sufficient for appointment removal

 Deliverables

Complete Laravel source code

Database migrations

.env.example (no secrets included)

REST API endpoints
