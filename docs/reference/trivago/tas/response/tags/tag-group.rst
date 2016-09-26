======================================
Trivago\\Tas\\Response\\Tags\\TagGroup
======================================

A tag group holds tags.

getGroupId()
============

.. code-block:: php

    public function int getGroupId()

The ID of a tag group.


getType()
=========

.. code-block:: php

    public function string getType()

Returns the type of the tag group. This can be one of this values:

- and
- or

When using an and tag to filter records, then a record needs to have all given tags to be displayed.
When using an or tag to filter records, then a records needs to have either one or another given tag to be displayed.

getName()
=========

.. code-block:: php

    public function string getName()

Returns the name of the tag group.

toArray()
=========

.. code-block:: php

    public function Tag[] toArray()

Returns all tags in an array.
