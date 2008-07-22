<?php
include('d:/htdocs/utils/classes/class.BaseOptimize.php');
$optim = new BaseOptimize;
// ������� ������, ������� full_delete
$optim->delFull_delete();

// ������� ������� ������� � ����
$optim->delRomsAuthors();

// ������� ������ �������
$optim->delEmptyAuthors();

// �������� ������ ������� �� �������
$optim->replacingWords();

// ������ ���� �� �������
$optim->getEpRating();

// ������� ������ "����� ������"
$optim->clearNewReleases();

// ������� ������ ����������

$optim->delEmptyFolders('h:/mp3/');
$optim->delEmptyFolders('l:/mp3/');
$optim->delEmptyFolders('m:/mp3/');
$optim->delEmptyFolders('t:/mp3/');
$optim->delEmptyFolders('f:/mp3/');
$optim->delEmptyFolders('g:/mp3/');
$optim->delEmptyFolders('i:/mp3/');
$optim->delEmptyFolders('j:/mp3/');
$optim->delEmptyFolders('n:/mp3/');
$optim->delEmptyFolders($optim->MP3ADMINDIRImages);

// ������������ ����
$optim->optimize_base();



?>