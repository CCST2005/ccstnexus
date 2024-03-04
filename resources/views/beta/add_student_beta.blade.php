<!DOCTYPE html>
<html>
<body>

<h2>Add student</h2>

<form action="{{ route('admin.adding_beta') }}" method="POST">
@csrf
    <label for="fname">Student no:</label><br>
  <input type="text" id="fname" name="studno" required value=""><br><br>

  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname" required value=""><br><br>

  <label for="lname">Middle name:</label><br>
  <input type="text" id="lname" name="mname" value=""><br><br>



  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname" required value=""><br><br>

  <label for="lname">Course:</label><br>
  <select name="Course" id="cars">
    @foreach($track as $course)
        <option value="{{ $course->id}}">{{ $course->course }}</option>
    @endforeach
  </select><br><br>

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
