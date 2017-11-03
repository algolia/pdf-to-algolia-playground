PDF to Algolia playground
---

In this repository you'll find examples of ways to extract text and metadata from PDFs.

We then showcase how to prepare the data in order to push it to Algolia.

All examples expect you to have a running [Apache tika Docker container](https://github.com/LogicalSpark/docker-tikaserver).

```
docker pull logicalspark/docker-tikaserver
docker run -d -p 9998:9998 logicalspark/docker-tikaserver
```

## PHP

### Extract Algolia records from PDF

By running the commands below, it will:
- extract the title and content from the PDF file located in data/pdf-sample.pdf
- split the content into several records that can then be queried easily with the `DISTINCT` feature

```bash
cd php
composer install
php single.php
```

Outputs:

```
array(2) {
  [0]=>
  array(4) {
    ["objectID"]=>
    string(16) "pdf-sample.pdf-0"
    ["filename"]=>
    string(14) "pdf-sample.pdf"
    ["title"]=>
    string(23) "This is a test PDF file"
    ["content"]=>
    string(611) "Adobe Acrobat PDF Files

Adobe® Portable Document Format (PDF) is a universal file format that preserves all
of the fonts, formatting, colours and graphics of any source document, regardless of
the application and platform used to create it.

Adobe PDF is an ideal format for electronic document distribution as it overcomes the
problems commonly encountered with electronic file sharing.

•  Anyone, anywhere can open a PDF file. All you need is the free Adobe Acrobat
Reader. Recipients of other file formats sometimes can't open files because they
don't have the applications used to create the documents."
  }
  [1]=>
  array(4) {
    ["objectID"]=>
    string(16) "pdf-sample.pdf-1"
    ["filename"]=>
    string(14) "pdf-sample.pdf"
    ["title"]=>
    string(23) "This is a test PDF file"
    ["content"]=>
    string(467) "•  PDF files always print correctly on any printing device.

•  PDF files always display exactly as created, regardless of fonts, software, and
operating systems. Fonts, and graphics are not lost due to platform, software, and
version incompatibilities.

•  The free Acrobat Reader is easy to download and can be freely distributed by
anyone.

•  Compact PDF files are smaller than their source files and download a
page at a time for fast display on the Web."
  }
}
```
