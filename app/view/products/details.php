<h1><?php echo $data['product']->name?></h1>
<h3>Zutaten</h3>
<ul>
    <?php foreach($data['ingredients'] as $ingredient):?>
        <li><?php echo $ingredient->name?></li>
    <?php endforeach;?>
</ul>