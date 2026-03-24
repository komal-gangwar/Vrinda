# Vrinda

Vrinda is a campus-focused bus tracking and notification system designed to improve commute visibility for students and faculty through real-time location updates and proactive alerts.

---

## Overview

Campus transportation often lacks transparency, leading to uncertainty and delays.  
Vrinda addresses this by providing live tracking, timely notifications, and clear route visibility to make commuting predictable and efficient.

---

## Features

- **Real-time Tracking**  
  Track buses live along predefined routes

- **Timely Notifications**  
  - Bus departure alerts  
  - Upcoming stop alerts  

- **Route Clarity**  
  Easily identify buses and routes

- **Improved Commute Experience**  
  Reduces wait-time uncertainty

---

## Tech Stack

**Frontend**
- HTML, CSS, JavaScript  
- HTMX  

**Backend**
- JavaScript  
- PHP  

**Database & APIs**
- MySQL  
- MapmyIndia Maps  
- Firebase Cloud Messaging  

**Infrastructure**
- AWS (EC2 — currently inactive)

---

## Architecture

- Client fetches bus and route data via lightweight endpoints  
- Backend processes and stores location data in MySQL  
- Map APIs render routes and positions  
- Firebase handles push notifications  

---

## Status

Development is currently paused.  
The application is not deployed (AWS instance stopped).

---

## Local Setup

```bash
git clone https://github.com/<your-username>/vrinda.git
cd vrinda
cp .env.example .env
