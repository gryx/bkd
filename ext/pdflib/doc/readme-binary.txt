==========================
PDFlib binary distribution
==========================

This is a binary package containing PDFlib, PDFlib+PDI, and
PDFlib Personalization Server (PPS) in a single binary.
It requires a commercial license to use it. However, the
library is fully functional for evaluation purposes.

Unless a valid license key has been applied the generated PDF
output will have a www.pdflib.com demo stamp across all pages.
See the PDFlib tutorial (chapter 0) to learn how to apply the
license key.

Note: operating systems requirements for using PDFlib are detailed in
the document system-requirements.txt.


C and C++ language bindings
===========================

The PDFlib header file pdflib.h plus a PDFlib library is contained in the
distribution.  The bind/c and bind/cpp directories contain sample
applications which you can use to test your installation.


-------
Windows
-------
Windows editions are available in the following flavors:

- 32-bit Windows DLL for C/C++
  The DLL pdflib.dll is supplied along with the
  corresponding import library pdflib.lib. In order to build
  and run the supplied C/C++ samples copy these files to the
  bind/c or bind/cpp directories.

- 64-bit Windows DLL for C/C++

- A static library is available upon request.

The Windows binaries are not compatible with Borland C++ Builder.


----
Unix
----
On Unix systems a static library is supplied. The bind/c and bind/cpp
directories contain sample applications and Makefiles which you can use
to test your installation.


----
OS X
----
The package for C/C++ contains the following libraries:

- static library
- PDFlib_objc.framework (must be installed manually in /Library/Frameworks)


-------
IBM AIX
-------
PDFlib for AIX has been built with the IBM C compiler (IBM XLC). 

Using PDFlib with gcc/g++ on AIX:
If you want to use PDFlib with C or C++ applications
which are built with gcc/g++: the GNU compiler on AIX by default is not fully
binary compatible with IBM XLC. The binary incompatibility affects passing
conventions for floating point function parameters, and may result in
unexpected behavior like crashes or weird PDFlib exceptions. In order to
build C or C++ applications with GCC for linkage with PDFlib you must use
the following GCC compilation option when compiling your application:
-mxl-compat

This will produce code which is compatible with the object code created by
IBM XLC, and therefore enables your application to link against PDFlib.


Other language bindings
=======================

Additional files and sample code for various languages can be found in
the bind directory. Note that not all binary libraries for all language
bindings may be present; see our Web site for additional packages.


=================================
Notes for using PDFlib on zSeries
=================================

Tuning z/OS Language Environment for PDFlib applications 

Due to the heavy use of LE's memory allocation routines, some tuning of
the Language Environment storage keywords will provide better application
performance and reduced CPU usage.

Optimized storage and heap initial allocations for the invoice sample:

STORAGE(NONE,NONE,NONE,0K)
HEAP(2600K,4080,ANYWHERE,KEEP,0K,4080)
HEAPP(ON,8,1,32,3,128,5,256,5,1024,45,2048,26)
ANYHEAP(24K,4080,ANYWHERE,FREE)

As the heap, heappool and stack allocations can vary widely by application,
occasional use of the LE Storage Report will provide you with additional
recommendations.

RPTOPTS(ON),RPTSTG(ON)

These options can be specified in your C source file through the use of
#pragma runopts(..).

COBOL and CICS applications can use the CEEUOPT mechanism.

Refer to the "z/OS Language Enviroment Programming Guide"
(http://publibz.boulder.ibm.com/epubs/pdf/ceea2130.pdf)
for further details on the use of these keywords.
