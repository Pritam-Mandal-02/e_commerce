<center>
  <h1><u>Order Receipt</u></h1>
</center>

<body>
  <table width="70%" border="1" align="center">
    <tbody>
      <tr>
        <th align="left">Product Name</th>
        <td><?= $row['name'] ?></td>
      </tr>
      <tr>
        <th align="left">Price (INR)</th>
        <td><?= $row['price'] ?></td>
      </tr>
      <tr>
        <th align="left">Quantity</th>
        <td><?= $row['quantity'] ?></td>
      </tr>
      <tr>
        <th align="left">Total (INR)</th>
        <td><?= $row['price'] * $row['quantity'] ?></td>
      </tr>
      <tr>
        <th align="left">Date</th>
        <td><?= date_format(date_create($row['date']), "d M, Y") ?></td>
      </tr>
    </tbody>
  </table>
</body>