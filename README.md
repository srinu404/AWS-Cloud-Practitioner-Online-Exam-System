# AWS Cloud Practitioner Online Exam System

## 📘 Overview
This is a web-based online examination system designed to simulate the AWS Cloud Practitioner certification exam. It supports student registration, timed exams, automatic evaluation, and secure admin question management.

---

## 🚀 Features

### Student
- Register and login
- One-time exam attempt
- 65 randomized questions
- 90-minute timer
- Single & multiple-choice questions
- Automatic scoring (1000 points)
- Pass/Fail evaluation
- Detailed result review
- Mobile-responsive UI

### Admin
- Secure login with session timeout
- Add, edit, delete questions
- Prevent duplicate questions
- Bulk upload (CSV)
- Search questions
- View user feedback
- Download uploaded PDFs

---

## 🛠 Tech Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Server: Apache (XAMPP)

---

## 📂 Folder Structure
```
AWS-Cloud-Practitioner-Exam-System/
│
├── index.php                     # Main landing page
├── student_dashboard.php         # Student options (Take Exam / Prepare)
├── register.php                  # Student registration
├── login.php                     # Student login
├── logout.php                    # Student logout
│
├── exam.php                      # Exam interface with live proctor
├── submit_exam.php               # Stores answers & results
├── result.php                    # Shows attempt-wise results
├── prepare.php                   # Study materials page
├── contact.php                   # Feedback submission page
│
├── config/
│   └── db.php                    # Database connection
│
├── css/
│   └── style.css                 # Global styling
│
├── js/
│   └── timer.js                  # 90-minute countdown timer
│
├── uploads/
│   ├── study_materials/          # Uploaded PDFs by admin
│   └── feedback_pdfs/            # PDFs uploaded by students
│
├── admin/
│   ├── admin_login.php
│   ├── admin_register.php
│   ├── logout.php
│   │
│   ├── manage_admins.php
│   ├── edit_admin.php
│   ├── delete_admin.php
│   │
│   ├── manage_students.php
│   ├── edit_student.php
│   ├── delete_student.php
│   │
│   ├── add_question.php
│   ├── edit_question.php
│   ├── delete_question.php
│   ├── bulk_upload.php
│   ├── manage_questions.php
│   │
│   ├── manage_materials.php
│   ├── delete_material.php
│   │
│   ├── view_feedback.php
│   ├── delete_feedback.php
│   │
│   ├── view_results.php
│   └── view_student_result.php
│
└── database/
    └── aws_exam.sql              # Complete database backup


```

## 🔐 Security
- Session-based authentication
- Admin-only protected routes
- Auto logout on inactivity
- One exam attempt per student

## 👨‍💻 Author
Developed as a full-stack PHP project for AWS Cloud Practitioner exam practice.

# STEPS TO DEPLOY IN AWS

Launch the Instance
- Yes, you are all set to launch the instance. Based on your current configuration:
- AMI: You have selected Ubuntu Server 24.04 LTS, which is perfect for your LAMP stack project.
- Instance Type: t3.micro is selected, which is within the Free Tier.
- Key Pair: You are using key pair "a". Ensure you have this .pem file safe on your computer.
- Firewall (Security Groups): You have correctly checked "Allow HTTP traffic from the internet" and "Allow SSH traffic from Anywhere" and "Allow HTTPS traffic from the internet".
- Domine name:- awsexam.us.cc

  https://awsexam.us.cc

#**Screenshot's**


