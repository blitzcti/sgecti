<p>Atualmente, você possui {{ sizeof($proposals) == 0 ? "nenhuma" : sizeof($proposals) }} {{ sizeof($proposals) < 2 ? "proposta" : "propostas" }} de estágio.</p>
<p>Destas propostas, {{ sizeof($proposalsApproved) == 0 ? "nenhuma" : sizeof($proposalsApproved) }} {{ sizeof($proposalsApproved) < 2 ? "está aprovada" : "estão aprovadas" }}.</p>


