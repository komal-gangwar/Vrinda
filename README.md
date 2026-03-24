Vrinda

Vrinda is a campus-focused bus tracking and notification system that improves daily commute visibility for students and faculty through real-time location updates and proactive alerts.

Overview

Campus transportation often lacks transparency, leading to uncertainty and delays. Vrinda addresses this by providing:

Live bus tracking
Intelligent notifications for departures and arrivals
Clear route identification

The goal is to make commuting predictable and efficient without requiring constant manual checking.

Core Features
Real-time Tracking
Track buses live along predefined routes
Event-based Notifications
Bus departure alerts
Upcoming stop alerts using push notifications
Route Visibility
Clear mapping of buses, stops, and routes
User-centric Design
Built to reduce wait time ambiguity and improve commute planning
Tech Stack

Frontend

HTML, CSS, JavaScript
HTMX (for dynamic UI without heavy frameworks)

Backend

JavaScript
PHP

Database & Integrations

MySQL
MapmyIndia Maps (routing and geolocation)
Firebase Cloud Messaging (push notifications)

Infrastructure

AWS (EC2-based deployment; currently inactive)
Architecture (High-Level)
Client requests route and bus data via lightweight endpoints
Backend processes location updates and stores them in MySQL
Map APIs render routes and positions
Firebase Cloud Messaging handles event-triggered notifications
Current Status

The project is currently paused and not deployed. The AWS instance has been stopped to manage costs.

Local Setup
# Clone repository
git clone https://github.com/<your-username>/vrinda.git
cd vrinda

# Setup environment
cp .env.example .env
Requirements
MySQL installed and running
MapmyIndia API key
Firebase project with Cloud Messaging enabled
PHP runtime and/or Node.js (depending on backend configuration)
Steps
Configure environment variables in .env
Initialize the database schema
Start backend server
Serve frontend locally
Security Notes
Sensitive data (.env, API keys, service JSON files) must not be committed
If secrets were previously exposed, clean history using tools like BFG Repo-Cleaner or git filter-repo
Future Improvements
Mobile-first UI or dedicated app
Predictive ETA using historical data
Role-based dashboards (admin / transport staff)
Route optimization and analytics
