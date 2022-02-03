<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        try {
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
            $msg = 'Updated Successfully!';
            if (!is_numeric($_POST['id'])){
                $msg = "ID must be numeric!";
            } else if (!is_numeric($_POST['phone'])){
                $msg = "Phone number must be numeric!";
            } else {
                $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
                $stmt->execute([$id, $name, $email, $phone, $title, $created, $_GET['id']]);
            }
        } catch (PDOException $exception) {

            if(str_contains($exception, '1062 Duplicate entry')) {
                $msg = "Contact with that ID already exists!";
            }
        }
    }
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$contact) {
        $msg = 'Contact ID has been updated!';
    }
    } else {
        $msg = 'No ID specified!';
    }
?>
<?=template_header('Read')?>

<div class="content update">
    <?php  if (isset($contact['id'])){?>
	<h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['email']?>" id="email">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone">
        <label for="title">Title</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" value="<?=$contact['title']?>" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php } ?>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>