<!DOCTYPE html>
<html>
<body>

<h2>UPDATE STUDENT SECTION</h2>

<form action="{{ route('admin.updating_section_student_beta') }}" method="POST">
@csrf
    <label for="fname">Student no:</label><br>
  <input type="text" id="fname" name="studno" required value=""><br><br>

  <br><br>

  <label for="lname">Section:</label><br>
  <select name="Section" id="cars">
  @foreach($Adminsection as $course)
        <option value="{{ $course->id}}">{{ $course->section }}</option>
    @endforeach
  </select><br><br>

  <input type="submit" value="Submit">
</form> 



</body>
</html>
