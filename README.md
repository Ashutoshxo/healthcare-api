📌 Healthcare REST API (Laravel)
🧩 Objective

Build a RESTful API to manage Patients and Appointments with proper validation, business rules, clean code, and correct HTTP responses.

🛠 Tech Stack

PHP 8+

Laravel 12

MySQL

Eloquent ORM

REST API (JSON responses)

🚀 Setup Instructions
git clone https://github.com/Ashutoshxo/healthcare-api.git
cd healthcare
composer install

Environment setup
cp .env.example .env
php artisan key:generate


Update database credentials in .env:

DB_DATABASE=healthcare
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password


Run migrations:

php artisan migrate


Start server:

php artisan serve

🗄 Database Schema
🧑 Patients Table (patients)
Column	Type	Notes
id	bigint	Primary Key
full_name	string	Required
phone	string	Required, Unique
email	string	Required, Unique
dob	date	Nullable
created_at	timestamp	Auto
updated_at	timestamp	Auto
📅 Appointments Table (appointments)
Column	Type	Notes
id	bigint	Primary Key
patient_id	bigint	Foreign Key → patients.id
doctor_name	string	Required
appointment_date	date	Required
appointment_time	time	Required
status	string	booked / completed / cancelled
notes	text	Nullable
deleted_at	timestamp	Soft delete
created_at	timestamp	Auto
updated_at	timestamp	Auto
🔗 Relationships

Patient has many Appointments

Appointment belongs to Patient

Unique constraint on
(patient_id, appointment_date, appointment_time)

🔗 API Endpoints
## 📌 Available API Routes

The following routes are registered in the application:

```text
POST    /api/patients
GET     /api/patients
GET     /api/patients/{id}

POST    /api/appointments
GET     /api/appointments
PATCH   /api/appointments/{id}/status
DELETE  /api/appointments/{id}
👤 Patients

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

Get Patient Details (latest 5 appointments)
GET /api/patients/{id}

📅 Appointments

Create Appointment
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


Delete Appointment (Soft Delete)
DELETE /api/appointments/{id}

✅ Business Rules Implemented

Appointments cannot be created in the past

Duplicate appointment slot for same patient is not allowed

Strong request validation using Form Request classes

Proper HTTP status codes:

201 Created

422 Validation error

404 Resource not found

Secure mass assignment handling

Soft deletes implemented for appointments

🧪 API Testing

All endpoints tested using Postman

JSON request bodies used

Success and validation failure cases verified

⚙️ Environment Notes

Database credentials are managed via .env

File-based cache and session drivers are used for local development

No environment-specific secrets are committed

📦 Deliverables

Full Laravel source code

Database migrations

.env.example file

REST API endpoints

Clean and readable codebase