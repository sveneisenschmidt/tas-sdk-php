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
