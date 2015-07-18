<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>full description of all products that have a rating 4.50 or higher</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>Name</th>
      <th>Full Description</th>
      <th>Rating</th>
    </tr>
    <xsl:for-each select="GeneralSearchResponse/categories/category/items/product">
       <xsl:if test="rating/rating &gt; 4.50">
	        <tr>
	          <td><xsl:value-of select="name"/></td>
	          <td><xsl:value-of select="fullDescription"/></td>
	          <td><xsl:value-of select="rating/rating"/></td>
	        </tr>
	   </xsl:if>
    </xsl:for-each>
  </table>
  
  <h2>name and the minimum price of all products whose name contains the word Sony</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>Name</th>
      <th>Price</th>
    </tr>
    <xsl:for-each select="GeneralSearchResponse/categories/category/items/product">
       <xsl:if test="contains(name, Sony)">
	        <tr>
	          <td><xsl:value-of select="name"/></td>
	          <td><xsl:value-of select="minPrice"/></td>
	        </tr>
	   </xsl:if>
    </xsl:for-each>
  </table>
  
  <h2>names of all products whose name contains the word Sony and the price is between $1000 and $2000, inclusive</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>Name</th>
      <th>Price</th>
    </tr>
    <xsl:for-each select="GeneralSearchResponse/categories/category/items/product">
       <xsl:if test="(contains(name, Sony) and minPrice &gt;=  1000 and minPrice &lt;= 2000)">
       	   <tr>
	          <td><xsl:value-of select="name"/></td>
	          <td><xsl:value-of select="minPrice"/></td>
	        </tr>
	   </xsl:if>
    </xsl:for-each>
  </table>
  
  
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>