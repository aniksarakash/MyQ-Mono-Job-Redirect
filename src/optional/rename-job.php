/* ============================================================
   OPTIONAL  |  tag the job name so the move is visible
   ------------------------------------------------------------
   Where : inside branch 5 (REDIRECT) of src/mono-redirect.php,
           placed BEFORE the $this->moveToQueue() line.
   Effect: the job shows as "[B&W] Report.docx" at the terminal,
           so users understand why it is not on the IM C2010.
   Note  : cosmetic only. It does not change routing.
   ============================================================ */

$this->name = "[B&W] " . $jobName;
