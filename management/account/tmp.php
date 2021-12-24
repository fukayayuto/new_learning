<div class="container">
    <form action="#" method="POST">

        <h2>メール履歴一覧</h2><br>

        <table class="table">
            <thead>
                <tr class="success">
                    　 　<td>ID</td>
                    　　　<td>種類</td>
                    <td>日付</td>
                    <td>宛先</td>
                    <td>本文</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $k => $val) : ?>
                    <tr>
                        　　　<td><?php echo $val['id']; ?></td>
                        <td><?php echo $val['type']; ?></td>
                        <td><?php echo $val['created_at']; ?></td>
                        <td><?php echo $val['account_list']; ?></td>
                        <td><a href="/management/mail/detail/?id=<?php echo $val['content_id']; ?>"><?php echo $val['title']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>