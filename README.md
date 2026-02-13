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
EXAM/
│
├── admin/                     # Admin-related files
│   ├── add_question.php       # Add new questions
│   ├── admin_login.php        # Admin login
│   ├── bulk_upload.php        # Bulk upload via CSV
│   ├── delete_question.php    # Delete questions
│   ├── edit_question.php      # Edit questions & options
│   ├── logout.php             # Admin logout
│   ├── manage_questions.php   # View & search questions
│   ├── session_check.php      # Session timeout & security
│   └── view_feedback.php      # View student feedback
│
├── config/
│   └── db.php                 # Database connection
│
├── css/
│   └── style.css              # Global styles (responsive)
│
├── js/
│   └── timer.js               # Exam countdown timer
│
├── uploads/                   # Uploaded PDFs (feedback)
│
├── contact.php                # Contact & feedback page
├── exam.php                   # Exam interface
├── index.php                  # Home page
├── login.php                  # Student login
├── register.php               # Student registration
├── result.php                 # Exam result & review
├── submit_exam.php            # Exam submission logic
├── result_logout.php          # Result page logout
├── view_result.php            # View result after login
│
└── README.md                  # Project documentation
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

  
