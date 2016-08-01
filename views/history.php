    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction</th>
                <th>Date/Time</th>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row["transaction"] ?></td>
                <td><?= $row["datetime"] ?></td>
                <td><?= $row["symbol"] ?></td>
                <td><?= $row["shares"] ?></td>
                <td>$<?= $row["price"] ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>