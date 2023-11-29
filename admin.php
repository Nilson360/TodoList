<?php
include_once 'functions.php';
 // Gérer la soumission du formulaire
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['add_task'])){
            addTask($_POST['title'], $_POST['description'],$_POST['due_date']);
        } elseif (isset($_POST['delete_task'])){
            deleteTask($_POST['delete_task']);
        } elseif (isset($_POST['update_task'])) {
            updateTask($_POST['task_id'], $_POST['title'],$_POST['description'],$_POST['due_date']);
        }
        header("Location: admin.php");
    }

    //gérér l'édition
    $taskToEdit = null;
    if(isset($_GET['edit'])){
        $taskToEdit = getTask($_GET['edit']);
    }

    // Récupérer toutes les tâches pour l'affichage
 $allTasks = getAllTasks();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Administration</title>
    <link rel="stylesheet" href="style/style.css">
   <script src="functions.js"></script>
</head>
<body>
   <!-- <h1>Administration de tâches</h1>-->
    <div class="task-add">
        <h2>Ajouter une nouvelle tâche</h2>

    <form method="post" action="<?php echo $taskToEdit?'admin.php?edit='.$taskToEdit['id']:'admin.php';?>">
        <input type="text" name="title" placeholder="Titre" required value="<?php echo $taskToEdit['title'] ?? ''; ?>">
        <textarea name="description" required placeholder="Description de la tâche"><?php echo $taskToEdit['description'] ?? '' ?></textarea>
        <input type="date" name="due_date" value="<?php echo $taskToEdit['due_date'] ?? ''; ?>" required>
        <?php if ($taskToEdit) : ?>
        <input type="hidden" name="task_id" value="<?php echo $taskToEdit['id']; ?>">
        <button type="submit" name="update_task" value="update_task">Mettre à jour</button>
        <?php else: ?>
        <button type="submit" name="add_task">Ajouter une tâche</button>
        <?php endif ?>
    </form>
    </div>

    <?php if($allTasks->num_rows >0) :?>
    <div class="task-container">
        <?php while($row = $allTasks->fetch_assoc()):?>
            <div class="task-card">
                <h3><?php echo htmlspecialchars($row['title'])?></h3>
                <p><?php echo htmlspecialchars($row['description'])?></p>
                <p>Date d'écheance : <?php echo htmlspecialchars($row['due_date'])?></p>
                <form method="post" action="admin.php" onsubmit="return confirmDelete('Êtes-vous sûr de vouloir supprimer cette tâche?')">
                    <input type="hidden" name="delete_task" value="<?php  echo $row['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <a href="admin.php?edit=<?php echo $row['id'];?>" class="modify-link">Modifier</a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
        <p> Aucune tâche trouvée.</p>
    <?php endif ?>
</body>
</html>

