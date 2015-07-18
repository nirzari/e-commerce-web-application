import javax.xml.parsers.*;

import org.w3c.dom.*;

import javax.xml.transform.*;
import javax.xml.transform.dom.*;
import javax.xml.transform.stream.*;

import java.io.*;
import java.net.URL;
import java.util.Scanner;


public class XSLT {
	
	 public static Document call ( String keyword ) throws Exception {
			DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
			DocumentBuilder db = dbf.newDocumentBuilder();
			Document doc = db.parse((new URL("http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&category=72&keyword="+keyword+"&numItems=20")).openStream());
			return doc;
	 }
	
    public static void main ( String argv[] ) throws Exception {
    	String s;
    	String files;
	    Scanner in = new Scanner(System.in);
	    System.out.println("Enter xsl filename");
	    files = in.nextLine();
    	File stylesheet = new File(files);
	    System.out.println("Enter a string");
	    s = in.nextLine();
		Document document = call(s);
		StreamSource stylesource = new StreamSource(stylesheet);
		TransformerFactory tf = TransformerFactory.newInstance();
		Transformer transformer = tf.newTransformer(stylesource);
		DOMSource source = new DOMSource(document);
		StreamResult result = new StreamResult(System.out);
		transformer.transform(source,result);
		in.close();
    }
}

//http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&category=72&keyword=sony&numItems=20