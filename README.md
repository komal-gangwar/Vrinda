<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vrinda - README</title>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      line-height: 1.6;
      max-width: 900px;
      margin: auto;
      padding: 2rem;
      color: #222;
    }
    h1, h2, h3 {
      margin-top: 1.5rem;
    }
    code {
      background: #f4f4f4;
      padding: 2px 6px;
      border-radius: 4px;
    }
    pre {
      background: #f4f4f4;
      padding: 1rem;
      overflow-x: auto;
      border-radius: 6px;
    }
    ul {
      margin-left: 1.2rem;
    }
  </style>
</head>
<body>

  <h1>Vrinda</h1>
  <p>
    Vrinda is a campus-focused bus tracking and notification system that improves commute visibility 
    for students and faculty through real-time location updates and proactive alerts.
  </p>

  <h2>Overview</h2>
  <p>
    Campus transportation often lacks transparency, leading to uncertainty and delays. 
    Vrinda addresses this by providing live tracking, intelligent notifications, and clear route visibility.
  </p>

  <h2>Core Features</h2>
  <ul>
    <li><strong>Real-time Tracking:</strong> Track buses live along predefined routes</li>
    <li><strong>Event-based Notifications:</strong>
      <ul>
        <li>Bus departure alerts</li>
        <li>Upcoming stop alerts</li>
      </ul>
    </li>
    <li><strong>Route Visibility:</strong> Clear mapping of buses, stops, and routes</li>
    <li><strong>User-centric Design:</strong> Reduces uncertainty and wait time</li>
  </ul>

  <h2>Tech Stack</h2>

  <h3>Frontend</h3>
  <ul>
    <li>HTML, CSS, JavaScript</li>
    <li>HTMX</li>
  </ul>

  <h3>Backend</h3>
  <ul>
    <li>JavaScript</li>
    <li>PHP</li>
  </ul>

  <h3>Database & Integrations</h3>
  <ul>
    <li>MySQL</li>
    <li>MapmyIndia Maps</li>
    <li>Firebase Cloud Messaging</li>
  </ul>

  <h3>Infrastructure</h3>
  <ul>
    <li>AWS (EC2 instance — currently stopped)</li>
  </ul>

  <h2>Architecture</h2>
  <ul>
    <li>Client requests bus and route data via lightweight endpoints</li>
    <li>Backend processes and stores location updates in MySQL</li>
    <li>Map APIs render routes and positions</li>
    <li>Firebase handles push notifications</li>
  </ul>

  <h2>Status</h2>
  <p>Development is currently paused. The project is not deployed.</p>

  <h2>Local Setup</h2>
  <pre><code>git clone https://github.com/&lt;your-username&gt;/vrinda.git
cd vrinda
cp .env.example .env
</code></pre>

  <h3>Requirements</h3>
  <ul>
    <li>MySQL</li>
    <li>MapmyIndia API key</li>
    <li>Firebase project (Cloud Messaging enabled)</li>
    <li>PHP runtime / Node.js</li>
  </ul>

  <h3>Steps</h3>
  <ol>
    <li>Configure environment variables in <code>.env</code></li>
    <li>Initialize database schema</li>
    <li>Start backend server</li>
    <li>Serve frontend locally</li>
  </ol>

  <h2>Security Notes</h2>
  <ul>
    <li>Do not commit sensitive files (<code>.env</code>, API keys)</li>
    <li>Clean git history if secrets were exposed</li>
  </ul>

  <h2>Future Improvements</h2>
  <ul>
    <li>Mobile-first UI or dedicated app</li>
    <li>Predictive ETA using historical data</li>
    <li>Admin dashboards</li>
    <li>Route optimization and analytics</li>
  </ul>

</body>
</html>
