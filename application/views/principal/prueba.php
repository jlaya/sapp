<table border="1">
    <caption>Prueba</caption>
    <thead>
        <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Fecha Naci</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($listar as $user)
        {
            ?>
            <tr>
                <td><?php echo $user->format_cedula();?></td>
                <td><?php echo $user->mayu_nombre();?></td>
                <td><?php echo $user->format_fecha();?></td>
            </tr>

            <?php
        }
        ?>
    </tbody>
</table>
