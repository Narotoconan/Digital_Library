<?php
require_once ("components/inquire.php");
$visitsTop=inquire("SELECT booklist.bookID, booklist.bookName, booklist.bookAuthor, booklist.bookCover, booklist.bookPress, booklist.bookVisits
                        FROM
                            booklist
                        ORDER BY
                            booklist.bookVisits DESC LIMIT 5");
$borrowTop=inquire("SELECT booklist.bookID, booklist.bookName, booklist.bookAuthor, booklist.bookCover, booklist.bookPress, booklist.bookBorrow
                        FROM
                            booklist
                        ORDER BY
                            booklist.bookBorrow DESC LIMIT 5");
$scoreTop=inquire("SELECT booklist.bookID, booklist.bookName, booklist.bookAuthor, booklist.bookCover, booklist.bookPress, booklist.bookScore
                        FROM
                            booklist
                        ORDER BY
                            booklist.bookScore DESC LIMIT 5");
?>
<link rel="stylesheet" href="lib/css/rankTop.css">
<div class="container">
    <div class="row mt-3 mb-3">
        <div class="col" id="visitsTop">
            <h5 class="mb-3">
                <span style="font-family: icomoon;font-size: 2rem;vertical-align: middle;color: #5cd69b;margin-right: 10px"></span>
                浏览量Top5
            </h5>
            <div class="list">
                <?php foreach ($visitsTop as $item):?>
                    <a href="bookPage.php?bookID=<?php echo $item['bookID']?>">
                        <div class="card mb-3 topList" style="max-width: 540px;height: 8.35rem;border-radius: 5px">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="<?php echo $item['bookCover']?>" class="card-img" alt="<?php echo $item['bookName']?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body pt-2">
                                        <h5 class="card-title rankBookName overflow-hidden mb-2"><?php echo $item['bookName']?></h5>
                                        <p class="card-text overflow-hidden" style="color: #5cd69b">
                                            <span>浏览量：</span>
                                            <span><?php echo $item['bookVisits']?></span>
                                        </p>
                                        <p class="card-text small"><?php echo $item['bookAuthor']?></p>
                                        <p class="card-text small text-black-50"><?php echo $item['bookPress']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach;?>
            </div>
        </div>
        <div class="col" id="borrowTop">
            <h5 class="mb-3">
                <span style="font-family: icomoon;font-size: 2rem;vertical-align: middle;color: #d6aa38;margin-right: 10px"></span>
                借阅量Top5
            </h5>
            <div class="list">
                <?php foreach ($borrowTop as $item):?>
                <a href="bookPage.php?bookID=<?php echo $item['bookID']?>">
                    <div class="card mb-3 topList" style="max-width: 540px;height: 8.35rem;border-radius: 5px">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?php echo $item['bookCover']?>" class="card-img" alt="<?php echo $item['bookName']?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body pt-2">
                                    <h5 class="card-title rankBookName overflow-hidden mb-2"><?php echo $item['bookName']?></h5>
                                    <p class="card-text overflow-hidden" style="color: #d6aa38">
                                        <span>借阅量：</span>
                                        <span><?php echo $item['bookBorrow']?></span>
                                    </p>
                                    <p class="card-text small"><?php echo $item['bookAuthor']?></p>
                                    <p class="card-text small text-black-50"><?php echo $item['bookPress']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
        <div class="col" id="scoreTop">
            <h5 class="mb-3">
                <span style="font-family: icomoon;font-size: 2rem;vertical-align: middle;color: #d66467;margin-right: 10px"></span>
                评 分Top5
            </h5>
            <div class="list">
                <?php foreach ($scoreTop as $item):?>
                <a href="bookPage.php?bookID=<?php echo $item['bookID']?>">
                    <div class="card mb-3 topList" style="max-width: 540px;height: 8.35rem;border-radius: 5px">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?php echo $item['bookCover']?>" class="card-img" alt="<?php echo $item['bookName']?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body pt-2">
                                    <h5 class="card-title rankBookName overflow-hidden mb-2"><?php echo $item['bookName']?></h5>
                                    <p class="card-text overflow-hidden" style="color: #d66467">
                                        <span>评 分：</span>
                                        <span><?php echo $item['bookScore']?></span>
                                    </p>
                                    <p class="card-text small"><?php echo $item['bookAuthor']?></p>
                                    <p class="card-text small text-black-50"><?php echo $item['bookPress']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
