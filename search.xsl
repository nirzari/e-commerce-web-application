<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>Search Results</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>Image</th>
      <th>Title</th>
      <th>Price</th>
      <th>Description</th>
    </tr>
    <xsl:for-each select="GeneralSearchResponse/categories/category/items/product">
        <tr>
          <td><img><xsl:attribute name="src"><xsl:value-of select="images/image/sourceURL"/></xsl:attribute></img></td>
          <td><xsl:value-of select="name"/></td>
          <td><xsl:value-of select="minPrice"/></td>
          <td><xsl:value-of select="fullDescription"/></td>
        </tr>
    </xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>