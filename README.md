# Gym Management System

A Laravel 11 application for managing a gym network with role-based access and gym subscription plans.

## Overview

This project is a multi-role gym management system built on Laravel 11. It supports three user roles:

- `main_admin`: manages gyms, global plans, gym subscriptions, and users.
- `gym_admin`: manages gym members, staff, sports, equipment, expenses, memberships, payments, attendance, billing, and gym settings.
- `staff`: manages members, payments, equipment, attendance, and personal profile settings.

## Key Features

- Authentication and role-based authorization
- Admin dashboard for system overview and gym management
- Gym creation and management
- Membership plans and gym plan subscriptions
- Member registration, attendance tracking, and payment recording
- Equipment, expense, and sport management
- User profile and security settings
- Contact form submission via public site

## Architecture

### Framework

- Laravel 11
- PHP 8.2+
- Vite for frontend asset compilation
- Bootstrap 5
- Composer dependency management

### Directory structure

- `app/Models/`: Eloquent models for the domain
- `app/Http/Controllers/`: HTTP controllers separated by role
  - `MainAdmin/`
  - `GymAdmin/`
  - `Staff/`
  - `Auth/`
- `app/Http/Requests/`: form request validation classes
- `app/Http/Middleware/`: custom middleware
- `routes/web.php`: web routes and role-based route groups
- `resources/views/`: Blade templates and dashboard views
- `database/migrations/`: schema migrations
- `database/seeders/`: initial seed data
- `public/`: compiled assets and entry script

### Route and access design

- `routes/web.php` defines three main route groups:
  - `main_admin.*` for main administrator features
  - `gym_admin.*` for gym administrator features
  - `staff.*` for staff user features
- `Auth::routes()` provides authentication routes
- `CheckUserStatus` middleware confirms the user is active and authorized
- `LoginController` handles login, role-based redirects, and failed login tracking

### Core models

- `User`: core application users with roles, status, profile image, and gym relation
- `Gym`: gym entities with operational details and relations for members, equipment, expenses, sports, memberships, and plans
- `Plan`: global plan definitions for gym subscription tiers
- `GymPlan`: gym-specific plan subscriptions with duration, payment, and status fields
- `Member`: gym members with attendance and payment history
- `Payment`: member payments, linked to membership and sport
- `Membership`: gym membership products
- `Attendance`: check-in/check-out records for gym members
- `Equipment`: gym equipment inventory

### Role-based controllers

- `app/Http/Controllers/MainAdmin/`
  - `DashboardController`
  - `GymController`
  - `PlanController`
  - `GymPlanController`
  - `UserController`
  - `ProfileController`
- `app/Http/Controllers/GymAdmin/`
  - `DashboardController`
  - `MemberController`
  - `StaffController`
  - `SportController`
  - `EquipmentController`
  - `ExpenseController`
  - `MembershipController`
  - `PaymentController`
  - `AttendanceController`
  - `BillingController`
  - `SettingController`
  - `ProfileController`
- `app/Http/Controllers/Staff/`
  - `DashboardController`
  - `MemberController`
  - `EquipmentController`
  - `PaymentController`
  - `AttendanceController`
  - `ProfileController`

### Validation and requests

Form validation is handled using request classes in `app/Http/Requests/`, including:

- `GymRequest`
- `MemberRequest`
- `PaymentRequest`
- `EquipmentRequest`
- `ExpenseRequest`
- `PlanRequest`
- `GymPlanRequest`
- `MembershipRequest`
- `ProfileUpdateRequest`
- `SettingsRequest`
- `PasswordChangeRequest`
- `ContactFormRequest`

These classes encapsulate authorization and validation rules for each resource.

## Database schema summary

- `users`: stores app users and role assignments
- `gyms`: stores gym records, location, phone, city, region, image, and status
- `plans`: store global plan packages
- `gym_plans`: link gyms to subscriptions with payment details and expiry
- `members`: gym members and personal info
- `payments`: member payment records
- `attendance`: check-in/out history
- `equipment`: gym equipment inventory
- `expenses`: expense tracking
- `memberships`: gym membership products
- `contacts`: contact form submissions
- `failed_logins`: failed login tracking
- `user_memberships`: optional membership assignments

## Seed data

- `database/seeders/PlanSeeder.php` seeds `Basic`, `Standard`, and `Premium` plans.
- `database/seeders/DatabaseSeeder.php` seeds a default `main_admin` user.

Default admin credentials:

- Email: `admin@mygym.com`
- Password: `password123`

## Installation and setup

```bash
cd /path/to/Gym-main
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run dev
php artisan storage:link
php artisan serve
```

Open the app at `http://127.0.0.1:8000`.

## Frontend assets

- `resources/css/` contains styles
- `resources/js/` contains JavaScript entry points
- `vite.config.js` configures Vite asset building
- `public/assets/` holds compiled assets

## Notes

- The app uses `Storage::url()` for gym image URLs, so `php artisan storage:link` is required for uploaded images.
- Auth redirect logic sends users to role-specific dashboards.
- `CheckUserStatus` middleware blocks inactive users and invalid roles.

## Project goals

This repo is designed to support a gym management workflow spanning system administration, gym operations, member services, and staff-led daily tasks. The architecture follows Laravel conventions with modular controllers per user role and Eloquent models for a clean domain layer.
