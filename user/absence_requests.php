<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user Dashboard</title>
  <link rel="stylesheet" href="../css/absence_requests.css">
</head>
<body>
  <div class="-dashboard">
    <h1>User Dashboard</h1>

    <h2>Request Absence:</h2>

    <form id="timeOffRequestForm">
      <label for="startDateTime">Start Date & Time:</label>
      <input type="datetime-local" id="startDateTime" name="startDateTime" required>
      
      <label for="endDateTime">End Date & Time:</label>
      <input type="datetime-local" id="endDateTime" name="endDateTime" required>

      <label for="typeOfAbsence">Type of Absence:</label>
      <select id="typeOfAbsence" name="typeOfAbsence" required>
        <option value="">Select type of absence</option>
        <option value="Half a day">Half a day</option>
        <option value="1 day">1 day</option>
        <option value="More than 1 day">More than 1 day</option>
      </select>

      <label for="reason">Reason:</label>
      <input type="text" id="reason" name="reason" placeholder="Enter reason" required>

      <button type="submit">Submit</button>
      <button type="reset">Cancel</button>
    </form>
  </div>
</body>
</html>
