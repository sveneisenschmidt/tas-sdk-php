# Docs

## Requirements to build the documentation 

1. Install Python 2.7
2. Install [Sphinx](http://www.sphinx-doc.org) for documentation generation: `pip install -U Sphinx`
    2.1 if your install fails because of `six`, add `--ignore-installed six` to your pip install command
3. Install Sphinx theme: `pip install sphinx_rtd_theme`

## Build the documentation in HTML

To create the HTML version of the documentation run the following command in the docs folder: `make html`
