<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/coach/styles.css">
    <link rel="stylesheet" href="../../styles/coach/coach_session.css">

    <title>Dashboard</title>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

    
    <main>
    <div class="main-body">


<div class="buttonSection">
<button>Add new Session</button>
</div>


<div class="tableSection">
<table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
    <th>Country</th>
    <th>Country</th>
    <th>Country</th>
    <th></th>


  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
    <td>Germany</td>
    <td>Germany</td>
    <td>Germany</td>
    <td><button>View profile</button></td>
    
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
    <td>Mexico</td>
    <td>Mexico</td>
    <td>Mexico</td>
    <td><button>View profile</button></td>

  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
    <td>Austria</td>
    <td>Austria</td>
    <td>Austria</td>
    <td><button>View profile</button></td>


  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
    <td>UK</td>
    <td>UK</td>
    <td>UK</td>
    <td><button>View profile</button></td>


  </tr>

</table>
</div>


    </div>
    </main>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>