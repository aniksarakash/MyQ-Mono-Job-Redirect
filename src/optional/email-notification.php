/* ============================================================
   OPTIONAL  |  email the user when their job is moved
   ------------------------------------------------------------
   Where : inside branch 5 (REDIRECT) of src/mono-redirect.php,
           placed BEFORE the $this->moveToQueue() line.
   Needs : Settings > Network > Outgoing SMTP configured in MyQ.
   Why   : MyQ Desktop Client popups only reach PCs running MDC.
           Email reaches everyone.
   ============================================================ */

$owner->sendEmail(
    "Your print job was moved",
    "Document: {$jobName}\r\n"
  . "Pages: {$pages}\r\n\r\n"
  . "The Ricoh IM C2010 is reserved for colour documents. Your document contains "
  . "no colour pages, so it can be collected from any other printer instead.\r\n\r\n"
  . "Your job has NOT been deleted."
);
