<?
/*
� ��������� ������� ������������ ��������� ����������:
0 ����������
1 ��������� ���� (inode)
2 ����� ������ ���������� ����
3 ���������� ������
4 ������������� ������������ ���������
5 ������������� ������ ���������
6 ��� ���������� ���������� ����
7 ������ � ������
8 ����� ���������� ���������
9 ����� ��������� �����������
10 ����� ���������� ���������
11 ������ ����� ��� �����/������ � �������� �������
*/
$file = "stat.php";

list($dev, $inode, $inodep, $nlink, $uid, $gid, $inodev, $size, $atime, $mtime, $ctime,

$bsize) = stat($file);
echo "Last modified: ".date( "H:i:s a", getlastmod( ) );
echo "<br>";
print "$file is $size bytes. <br>";
print "Last access time: $atime <br>";
print "Last modification time: $mtime <br>";
echo "Last access: ".date( "H:i:s a", $atime)."<br>";
echo "Last modification: ".date( "H:i:s a", $mtime)."<br>";
echo "CurTime: ".date( "H:i:s a")."<br>";
?>