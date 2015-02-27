<h1>Привет <?php echo $desc; ?>!</h1>
<?foreach ($db as $i):?>
    <p><?print_r($i->name)?></p>
<?endforeach?>