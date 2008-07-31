  <table width="100%">
    <tr style="background-color:#eeeeee;">
      <td width="20">
        <font size="4">{$article.article_name}</font>
          &nbsp;&nbsp;&nbsp;
          <small>автор: <b>{$article.users_name}</b></small>
        </font>
      </td>
    </tr>
    <tr>
      <td>{$article.article_text}</td>
    </tr>
    <tr>
      <td align="right"><small>{$article.article_timestamp|date_format}</small></td>
    </tr>
  </table>