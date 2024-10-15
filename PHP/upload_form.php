<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Upload Form</title>
  <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/Upload_form_css.CSS">
</head>
<body>
  <form action="/DIY_Project_sharing_platform/PHP/upload.php" method="POST" enctype="multipart/form-data">
    
  <div class="container">

  <div class="form-group">
    <h2>Project Upload</h2><br/><br/>
        <label for="pdfFile">Upload PDF</label>
        <input type="file" id="pdfFile" name="pdf_File" accept=".pdf" required>
      </div>
      <div class="form-group">
        <label for="videoUrl">Video URL</label>
        <input type="text" id="videoUrl" name="video_Url">
      </div>
      <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" id="image" name="image" accept="image/*" value="file" required>
      </div>
      <div class="form-group">
        <label for="Upload date">Upload Date</label>
        <input type="date" id="upload_date" name="upload_Date" required>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
