import {EntityType} from "./entity-type";
import {EntityViewMode} from "./entity-view-mode";

export interface EntityViewConfig {
  type: EntityType,
  id: string | undefined,
  mode: EntityViewMode,
}
