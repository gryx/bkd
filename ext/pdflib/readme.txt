================================================
PDFlib - A library for generating PDF on the fly
================================================

Portable library for dynamically generating PDF documents with support
for many other programming languages and development environments.

PDFlib distribution packages for many platforms are available from
www.pdflib.com.

PDFlib is a library for generating PDF files. It offers an API with
support for text, vector graphics, raster images, and hypertext. Call PDFlib
routines from within your client program and voila: dynamic PDF files!

PDFlib is available on a wide variety of operating system platforms,
and supports many programming languages and development environments:

- C
- C++
- Cobol
- COM (Visual Basic, ASP, Windows Script Host, and many others)
- Java via the JNI, including servlets and JSP
- .NET framework (VB.NET, ASP.NET, C# and others).
- Objective-C
- Perl
- PHP
- Python
- REALbasic
- RPG
- Ruby

An overview of PDFlib features can be found in the PDFlib Tutorial and
the PDFlib API Reference.


PDFlib flavors
==============
The PDFlib product family includes the following products (see the PDFlib
tutorial for a detailed comparison):

- PDFlib includes a variety of functions for generating PDF output.

- PDFlib+PDI includes all PDFlib functions, plus the PDF Import Library (PDI)
  for including existing PDF pages in the generated output. It also includes
  the pCOS interface for querying PDF objects.

- PDFlib Personalization Server (PPS) includes PDFlib+PDI plus functions for
  automatically filling PDFlib Blocks. A PPS license also covers the
  PDFlib Block Plugin for creating Blocks interactively with Adobe Acrobat
  on OS X and Windows.


Binary Packages
===============
PDFlib, PDFlib+PDI, and PPS are available in binary form, and require
a commercial license. All of these products are available in a single
combined library, and can be evaluated without a commercial license. However,
unless a valid license key is applied a demo stamp will be generated
across all pages, and the pCOS facility (included in PDFlib+PDI and PPS)
is restricted to small input documents.

Instructions for using the binary packages for various platforms and
language bindings can be found in the document readme-binary.txt.


Other PDFlib resources
======================
In addition to the PDFlib API Reference and Tutorial the following resources
are available:

- The PDFlib mailing list discusses PDFlib deployment in a variety of
  environments. You can access the mailing list archives over the Web,
  and don't need to subscribe in order to use it:
  tech.groups.yahoo.com/group/pdflib

- Commercial PDFlib licensees are eligible to standard product
  support from PDFlib GmbH. Please send your inquiry along with your
  PDFlib license number to support@pdflib.com.


Submitting Bug Reports
======================
We offer support agreements in combination with our product licenses.
They provide many advantages over the lifetime of a purchased product,
see www.pdflib.com/support-policy/ for more details.

If you run into a problem you should first make sure that you are using the
latest maintenance release for the version you licensed. Maintenance
releases are available for free download from the www.pdflib.com Web site.

If the problem persists please observe the notes below.

If you have trouble with a PDFlib product, please send the following
information to support@pdflib.com:

- Your company name and (unless you are still evaluating the product)
  your license key

- A description of your problem

- Exact product version (including maintenance release and possibly
  patchlevel number), the operating system platform and language binding
  
- Relevant code snippets for reproducing the problem, or a small PDF file
  exhibiting the problem if you can't construct a code snippet easily
  
- Sample data files if necessary (image files, for example).
  We guarantee full confidentiality within PDFlib GmbH for data supplied
  with support cases.

- In some cases PDFlib logging output may be required. Logging can be
  enabled as follows:
  
  command-line: export PDFLIBLOGGING="filename=trace.log"
  source code: p.set_option("logging={filename=trace.log}");
  (or similar for other shells and language bindings).
  
- Details of the PDF viewer (if relevant) where the problem occurs


Licensing
=========
Please contact us if you are interested in obtaining a commercial license:

PDFlib GmbH
Licensing Department
Franziska-Bilek-Weg 9, 80339 Munich, Germany
www.pdflib.com
fax +49/89/452 33 84-99

License inquiries: sales@pdflib.com
Support requests: support@pdflib.com
