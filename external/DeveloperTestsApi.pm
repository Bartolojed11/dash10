use logic::RouteController;
use logic::Collection;
use logic::JSONExporter;

package Pages::DeveloperTestsApi;

our @ISA = ('RouteController');

# =method routes	defines all of the routes under this component
sub routes {
	return qw/main/;
}

# =method main entry point
#
# =parameters
# $CGI->{endpoint}  string - which endpoint to load
sub main {
	my ($self, $request) = @_;
	return {error => 'invalid api key', status => 403}
		unless $request->cgi('API_KEY') eq 'few823mv__570sdd0342';
	my $endpoint = $request->cgi('endpoint');

	# acceptable endpoints
	my @endpoints = qw/allblacks nba.players nba.stats/;
	return {error => "invalid endpoint", status => 404}
		unless new Collection(@endpoints)->contains($endpoint);

	my $data = $self->data($endpoint);

	# find filters set in the CGI that match a key in the data
	my $keys = [keys %{$data->[0]}];
	my $filters = $self->filters($request, $keys) || {};

	return $data->filter(sub {
		my ($row) = @_;

		foreach my $key (keys %$filters) {
			$filter_values = new Collection($filters->{$key} || []);
			return unless $filter_values->contains($row->{$key});
		}
		return 1;
	})->to_arrayref();
}

# =method find filters in incoming CGI that match a key in the data
#
# =parameters
# request   IncomingRequest
# supported  arrayref - supported filter keys
sub filters {
	my ($self, $request, $supported) = @_;

	return new Collection($supported)
		->filter(sub {
			return defined $request->cgi(shift());
		})
		->map_with_keys(sub {
			my $key = shift();
			return $key => [split(/\s*,\s*/, $request->cgi($key))];
		});
}

# =method data read a JSON data source & return an Collection of its contents
#
# =parameters
# source   string name of the data source e.g. nba.players
sub data {
	my ($self, $source) = @_;

	# security checks
	$source =~ s/^\///;
	$source =~ s/\.\///g;

	my $content = $::Tag->file('pages/developer_tests/' . $source . '.json', 'raw');

	return new Collection(
		JSONExporter->decode($content)
	);
}

1;
