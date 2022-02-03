<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (!empty($_POST)) {
    try {
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $msg = 'Created Successfully!';
        if (is_numeric($_POST['phone']) || $_POST['phone'] == null){
            if($_POST['name'] == null || $_POST['email'] == null || $_POST['phone'] == null || $_POST['title'] == null){
                $msg = "Fields can't be empty!";
            } else {
                $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$id, $name, $email, $phone, $title, $created]);
            }
        } else {
            $msg = "Phone number must be numeric!";
        }
        
    } catch (PDOException $exception) {
        if(str_contains($exception, '1062 Duplicate entry')) {
            $msg = "Contact with that ID already exists!";
        }
    }
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input style="color: #ffffff" type="text" name="id" placeholder="26" value="auto" id="id" disabled>
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" id="email">
        <input type="text" minlength="9" maxlength="9" name="phone" placeholder="Input 9 digit number" id="phone">
        <label for="title">Title</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" id="title">
        <input style="color: #ffffff" type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created" disabled>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>