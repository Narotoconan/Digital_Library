<?php
require_once ("inquire.php");
$books=inquire("SELECT booklist.bookID, booklist.bookName, booklist.bookAuthor, booklist.bookCover, booklist.bookPress, bookcategory.bookCategory
                    FROM
	                    booklist
	                INNER JOIN
	                    bookcategory
	                ON 
		                booklist.bookCategory = bookcategory.categoryNum
                    ORDER BY
	                    RAND() ASC LIMIT 8");
$announcements=inquire("SELECT announcement.* FROM announcement  ORDER BY announcement.date DESC LIMIT 5");
?>

<link rel="stylesheet" href="lib/css/recommend.css">
<div class="container">
    <div class="row">
        <div class="col-9 mt-4 mb-5">
            <h5>
                <span style="font-family: icomoon;color: #0076d6;font-size: 2rem;vertical-align: middle"></span>
                图书推荐
            </h5>
            <div class="books mt-3 d-flex flex-wrap">
                <?php foreach ($books as $item):?>
                    <a href="bookPage.php?bookID=<?php echo $item['bookID']?>">
                        <div class="p-2">
                            <div class="card bookItems" style="width: 13.406rem;">
                                <img src="<?php echo $item['bookCover']?>" class="card-img-top" alt="<?php echo $item['bookName']?>">
                                <div class="card-body">
                                    <h5 class="card-title overflow-hidden bookName"><?php echo $item['bookName']?></h5>
                                    <div class="category mb-1" style="font-size: 12px">
                                        <?php echo $item['bookCategory']?>
                                    </div>
                                    <p class="card-text small mb-1"><?php echo $item['bookAuthor']?></p>
                                    <p class="card-text small text-black-50"><?php echo $item['bookPress']?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach;?>
            </div>
        </div>
        <div id="announcement" class="col-3 mt-4">
            <h5 class="clearfix">
                <span style="font-family: icomoon;color: #1487ff;font-size: 2rem;vertical-align: middle"></span>
                公 告
                <a href="annList.php" class="float-right pt-1"><small>更多...</small></a>
            </h5>
            <div class="mt-3 overflow-auto" style="padding-top: 8px;height: 792px">
                <div class="list-group">
                    <a href="rules.php">
                        <div class="card mb-3" style="border-radius: 5px">
                            <div class="card-body" data-toggle="modal" style="cursor: default">
                                <h5 class="card-title text-primary">图书馆规章制度</h5>
                            </div>
                        </div>
                    </a>
                    <?php foreach ($announcements as $item):?>
                        <a href="announcement.php?annID=<?php echo $item['announcementID']?>">
                            <div class="card mb-3" style="border-radius: 5px">
                                <div class="card-body" data-toggle="modal" style="cursor: default">
                                    <h5 class="card-title"><?php echo $item['title']?></h5>
                                    <p class="card-text mt-3"><small class="text-muted"><?php echo $item['date']?></small></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
