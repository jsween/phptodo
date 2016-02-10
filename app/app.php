<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    session_start();

    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();
    }

    $app = new Silex\Application();

    $app->get("/", function() {

        $output = "";

        $all_tasks = Task::getAll();

        if (!empty($all_tasks)) {
            $output .= "
                <h1>To Do List</h1>
                <p>Here are all your tasks:</p>
                ";

            foreach ($all_tasks as $task) {
                $output = $output . "<p>" . $task->getDescription() . "</p>";
            }

        }

        $output = $output . "
            <form action='/tasks' method='post'>
                <label for='description'>Task Description</label>
                <input id='description' name='description' type='text'>

                <button type='submit'>Add task</button>
            </form>
        ";

        $output .= "
            <form action='/delete_tasks' method='post'>
                <button type='submit'>delete</button>
            </form>
        ";

        return $output; 
    });

    $app->post("/tasks", function() {
        $task = new Task($_POST['description']);
        $task->save();
        return "
            <h1>You created more work for yourself!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'>View your list of things to do.</a></p>
        ";
    });

    $app->post("/delete_tasks", function() {

        Task::deleteAll();

        return "
            <h1>Way to Clear Everything Without Working!</h1>
            <p><a href='/'>Home</a></p>
        ";
    });

    return $app;



 ?>
