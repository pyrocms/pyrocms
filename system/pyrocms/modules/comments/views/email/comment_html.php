<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><h3>You have recieved a comment from {pyro:name}</h3></td>
	</tr>
	<tr>
		<td width="33%"><strong>IP Address: {pyro:sender_ip}</strong></td>
		<td width="33%"><strong>Operating System: {pyro:sender_os}</strong></td>
		<td width="33%"><strong>User Agent: {pyro:sender_agent}</strong></td>
	</tr>
	<tr>
		<td colspan="3">
			<hr />
			{pyro:comment}
			<br />
		</td>
  </tr>
	<tr>
		<td colspan="3">
			View Comment:{pyro:redirect_url}
		</td>
	</tr>
</table>