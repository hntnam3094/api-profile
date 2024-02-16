
'use client';

import { Button, Modal } from 'flowbite-react';
import { useState } from 'react';

export default function HasModal({isShow, children, emitCloseModal, title}) {
  const [openModal, setOpenModal] = useState(isShow === true);

  function closeModal () {
    setOpenModal(false)
    emitCloseModal()
  }

  return (
    <>
      <Modal show={openModal} onClose={() => closeModal()}>
        <Modal.Header>{title}</Modal.Header>
        <Modal.Body>
            {children}
        </Modal.Body>
        <Modal.Footer className="justify-end">
          <Button onClick={() => closeModal()}>Submit</Button>
          <Button color="gray" onClick={() => closeModal()}>
            Cancel
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  );
}
