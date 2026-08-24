/* ============================================================
   MONO JOB REDIRECT  |  keep B&W jobs off the Ricoh IM C2010
   ------------------------------------------------------------
   Queue  : secure          <-- existing user-facing queue
   Field  : Job processing > Scripting (PHP) > Actions after processing
   Target : secure_mono     <-- same printers as secure, minus IM C2010
   Ref    : docs.myq-solution.com/en/myq-x/10.2/print-server/php-scripts-actions-examples
   ------------------------------------------------------------
   Jobs are NEVER deleted. B&W jobs are moved, not destroyed.

   IMPORTANT
   1. MyQ supplies the PHP context. Do NOT paste an opening <?php tag.
   2. moveToQueue() must stay the final statement in the script.
   3. Never place this script on the target queue. It will loop.
   ============================================================ */

// ---------- CONFIGURATION ------------------------------------
$ENFORCE    = false;              // false = log only. true = actually move jobs.
$MONO_QUEUE = "secure_mono";      // exact queue name, case sensitive

// ---------- READ JOB / USER DATA -----------------------------
$jobName  = $this->name;
$srcQueue = $this->queue->name;
$owner    = $this->owner;
$userName = $owner->name;
$isColor  = $this->color;
$colorPgs = $this->colorCount;
$monoPgs  = $this->monoCount;
$pages    = $this->pageCount;

// ---------- 1. PARSER SAFETY ---------------------------------
// No colour data means the parser could not read the job.
// Never guess. Leave the job exactly where it is.
if ($isColor === null && $colorPgs === null) {

    MyQ()->logWarning(
        "[MonoRedirect] No colour data from parser. Job '{$jobName}' ({$userName}) "
      . "left on '{$srcQueue}'. Check Settings > Jobs > Job Parser."
    );

} else {

    $hasColour = ($isColor === true) || ($colorPgs !== null && $colorPgs > 0);

    // ---------- 2. COLOUR JOB, LEAVE IT ----------------------
    if ($hasColour === true) {

        MyQ()->logInfo(
            "[MonoRedirect] Colour job '{$jobName}' ({$userName}) "
          . "colour={$colorPgs} mono={$monoPgs} - stays on '{$srcQueue}'."
        );

    // ---------- 3. TEST MODE ---------------------------------
    // Reports what enforcement would do. Changes nothing.
    } elseif ($ENFORCE === false) {

        MyQ()->logNotice(
            "[MonoRedirect] TEST MODE - '{$jobName}' ({$userName}, {$pages} pages) "
          . "would move to '{$MONO_QUEUE}'."
        );

    // ---------- 4. NO RIGHTS, LEAVE IT, DO NOT LOSE IT -------
    // moveToQueue fails without rights on the target queue.
    } elseif ($owner->canPrintToQueue($MONO_QUEUE) === false) {

        MyQ()->logError(
            "[MonoRedirect] '{$userName}' has NO rights to '{$MONO_QUEUE}'. "
          . "Job '{$jobName}' left on '{$srcQueue}'. Copy the rights from 'secure'."
        );

    // ---------- 5. REDIRECT ----------------------------------
    } else {

        $owner->sendNotification(
            "info",
            "Black and white job",
            "The Ricoh IM C2010 is for colour documents only. Your job is safe and "
          . "can be collected from any other printer."
        );

        MyQ()->logInfo(
            "[MonoRedirect] Moving '{$jobName}' ({$userName}, {$pages} pages) "
          . "from '{$srcQueue}' to '{$MONO_QUEUE}'."
        );

        $this->moveToQueue($MONO_QUEUE);   // must be the last statement
    }
}
