<?php

class Person
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Student extends Person
{
    private $roll;
    private $marks;

    public function __construct($name, $roll, $marks)
    {
        parent::__construct($name);

        $this->roll = $roll;
        $this->setMarks($marks);
    }

    public function getRoll()
    {
        return $this->roll;
    }

    public function getMarks()
    {
        return $this->marks;
    }

    public function setMarks($marks)
    {
        if (is_numeric($marks) && $marks >= 0 && $marks <= 100)
        {
            $this->marks = $marks;
        }
        else
        {
            $this->marks = null;
        }
    }

    public function getGrade()
    {
        if ($this->marks === null)
        {
            return "Invalid marks";
        }
        elseif ($this->marks >= 90)
        {
            return "A";
        }
        elseif ($this->marks >= 80)
        {
            return "B";
        }
        elseif ($this->marks >= 70)
        {
            return "C";
        }
        elseif ($this->marks >= 60)
        {
            return "D";
        }
        else
        {
            return "F";
        }
    }
}

class GraduateStudent extends Student
{
    private $degree;

    public function __construct($name, $roll, $marks, $degree)
    {
        parent::__construct($name, $roll, $marks);

        $this->degree = $degree;
    }

    public function getDegree()
    {
        return $this->degree;
    }
}


interface StudentRepositoryInterface
{
    public function addStudent($student);

    public function getAllStudents();
}


class StudentRepository implements StudentRepositoryInterface
{
    private $students = array();

    public function addStudent($student)
    {
        $this->students[] = $student;
    }

    public function getAllStudents()
    {
        return $this->students;
    }
}


echo "Student Management System\n";

$repository = new StudentRepository();

$choice = "yes";

while ($choice == "yes")
{
    echo "\nEnter student type (student/graduate): ";
    $type = strtolower(trim(fgets(STDIN)));

    if ($type != "student" && $type != "graduate")
    {
        echo "Invalid student type. Try again.\n";
        continue;
    }

    echo "Enter student name: ";
    $name = trim(fgets(STDIN));

    echo "Enter roll number: ";
    $roll = trim(fgets(STDIN));

    echo "Enter marks (0-100): ";
    $marks = trim(fgets(STDIN));

    if ($type == "graduate")
    {
        echo "Enter degree: ";
        $degree = trim(fgets(STDIN));

        $student = new GraduateStudent(
            $name,
            $roll,
            $marks,
            $degree
        );
    }
    else
    {
        $student = new Student(
            $name,
            $roll,
            $marks
        );
    }

    
    $repository->addStudent($student);

    echo "\nStudent Details\n";
    echo "Name: " . $student->getName() . "\n";
    echo "Roll Number: " . $student->getRoll() . "\n";

    if ($student->getMarks() === null)
    {
        echo "Marks: Invalid\n";
    }
    else
    {
        echo "Marks: " . $student->getMarks() . "\n";
    }

    echo "Grade: " . $student->getGrade() . "\n";

    if ($student instanceof GraduateStudent)
    {
        echo "Degree: " . $student->getDegree() . "\n";
    }

    echo "\nDo you want to enter another student? (yes/no): ";
    $choice = strtolower(trim(fgets(STDIN)));
}


// Display all students stored in the repository
echo " All Students";

$allStudents = $repository->getAllStudents();

foreach ($allStudents as $student)
{
    echo "\nName: " . $student->getName() . "\n";
    echo "Roll Number: " . $student->getRoll() . "\n";

    if ($student->getMarks() === null)
    {
        echo "Marks: Invalid\n";
    }
    else
    {
        echo "Marks: " . $student->getMarks() . "\n";
    }

    echo "Grade: " . $student->getGrade() . "\n";

    if ($student instanceof GraduateStudent)
    {
        echo "Degree: " . $student->getDegree() . "\n";
    }

}

echo "\nStudent Management System Closed.\n";

?>
```