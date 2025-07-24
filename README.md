# SAIL-PROJECT-FINAL
his is a full-stack Vendor Invoice Management System built as part of my internship at Steel Authority of India Limited (SAIL). It helps streamline invoice uploads, approvals, and sales predictions using OCR and AI.
![AI-powered Invoice Dashboard](./banner3.png)

Login/register→ Upload Invoice →  Extract Text (OCR) → Store in MySQL →  Use in Chatbot or Dashboard
SAIL-PROJECT/
├── index.php               # Login page
├── register.php            # Registration
├── dashboard.php           # Dashboard view
├── upload.php              # Invoice upload with OCR
├── chatbot.py              # AI chatbot (sales predictions)
├── invoice_status.php      # Admin view to approve/reject
├── db.php                  # DB connection
├── /screenshots/           # Screenshots for README
├── README.md               # This file
└── ...

Tech Stack
Frontend	Backend	AI & OCR	Database
HTML, CSS, JS	PHP (Replit)	Tesseract OCR	MySQL (FreeSQL)
Chart.js	Streamlit Chatbot	Google Colab + Prophet	
👉 IMPORTANT: This repo originally contained database credentials. They’ve now been removed for security.
📌 If you're forking this, please add your credentials to a separate config.php file and don’t commit it!

---

Feel free to explore or contribute!
